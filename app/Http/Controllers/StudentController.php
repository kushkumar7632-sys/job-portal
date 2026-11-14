<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Application;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class StudentController extends Controller
{
    //
    public function register(){
        return view('student.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:100',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|digits:10',
            'password' => 'required|min:6|confirmed',
        ]);

        Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        return redirect('/student/register')->with('success','Registration Successful!');

    }
    public function showLogin()
    {
        return view('student.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $normalizedEmail = Str::lower(trim($request->input('email', '')));
        $throttleKey = 'student-login:' . $normalizedEmail . '|' . $request->ip();
        $ipKey = 'student-login-ip:' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()
                ->withErrors(['email' => "Too many login attempts. Please try again in {$seconds} seconds."])
                ->with('error', "Too many login attempts. Please try again in {$seconds} seconds.")
                ->onlyInput('email');
        }

        if (RateLimiter::tooManyAttempts($ipKey, 20)) {
            $seconds = RateLimiter::availableIn($ipKey);
            return back()
                ->withErrors(['email' => "Too many login attempts from this IP address. Please try again in {$seconds} seconds."])
                ->with('error', "Too many login attempts from this IP address. Please try again in {$seconds} seconds.")
                ->onlyInput('email');
        }

        $student = Student::where('email', $normalizedEmail)
                          ->orWhere('email', $request->input('email'))
                          ->first();

        if (!$student || !Hash::check($request->password, $student->password)) {
            RateLimiter::hit($throttleKey, 60);
            RateLimiter::hit($ipKey, 60);

            return back()
                ->withErrors(['email' => 'Invalid email or password.'])
                ->with('error', 'Invalid email or password.')
                ->onlyInput('email');
        }

        RateLimiter::clear($throttleKey);

        session([
            'student_id' => $student->id,
            'student_name' => $student->name,
        ]);

        $request->session()->regenerate();

        return redirect('/student/dashboard');
    }
    public function dashboard()
    {
        $studentId = session('student_id');
        $student = Student::findOrFail($studentId);

        // Dynamic application statistics for the logged-in student
        $totalApplications = Application::where('student_id', $studentId)->count();
        $pendingApplications = Application::where('student_id', $studentId)->where('status', 'Pending')->count();
        $shortlistedApplications = Application::where('student_id', $studentId)->where('status', 'Shortlisted')->count();
        $selectedApplications = Application::where('student_id', $studentId)->where('status', 'Selected')->count();
        $rejectedApplications = Application::where('student_id', $studentId)->where('status', 'Rejected')->count();

        // Student's latest 3 applications with job and company
        $recentApplications = Application::with('job.company')
            ->where('student_id', $studentId)
            ->latest()
            ->take(3)
            ->get();

        // Check if student has at least one application with resume
        $latestApplicationWithResume = Application::where('student_id', $studentId)
            ->whereNotNull('resume')
            ->latest()
            ->first();

        return view('student.dashboard', compact(
            'student',
            'totalApplications',
            'pendingApplications',
            'shortlistedApplications',
            'selectedApplications',
            'rejectedApplications',
            'recentApplications',
            'latestApplicationWithResume'
        ));
    }

    public function profile()
    {
        $student = Student::findOrFail(session('student_id'));

        return view('student.profile', compact('student'));
    }

    public function updateProfile(Request $request)
    {
        $student = Student::findOrFail(session('student_id'));

        $request->validate([
            'name'  => 'required|string|min:3|max:100',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('students', 'email')->ignore($student->id),
            ],
            'phone' => 'required|digits:10',
        ]);

        $normalizedEmail = Str::lower(trim($request->input('email')));

        $student->update([
            'name'  => trim($request->input('name')),
            'email' => $normalizedEmail,
            'phone' => trim($request->input('phone')),
        ]);

        // Synchronize session immediately
        session(['student_name' => $student->name]);

        return redirect()->route('student.profile')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $student = Student::findOrFail(session('student_id'));

        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|string|min:6|confirmed|different:current_password',
        ], [
            'password.different' => 'The new password must be different from your current password.',
        ]);

        if (!Hash::check($request->input('current_password'), $student->password)) {
            return back()->withErrors(['current_password' => 'The provided current password does not match our records.']);
        }

        $student->update([
            'password' => Hash::make($request->input('password')),
        ]);

        // Regenerate session ID for security
        $request->session()->regenerate();

        return redirect()->route('student.profile')->with('success', 'Password updated successfully.');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('student.login')->with('success', 'Logout Successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;


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
            'password' => 'required'
        ]);
        $student = Student::where('email',$request->email)->first();

        if (!$student){
            return back()->with('error','Email not found.');
        }

        if (!Hash::check($request->password, $student->password)){
            return back()->with('error','incorrect password.');
        }
        
        session([
            'student_id' => $student->id,
            'student_name' => $student->name,
        ]);

        return redirect('/student/dashboard');
    }
    public function dashboard()
    {
        return view('student.dashboard');
    }

    public function logout(){
        session()->flush();

        return redirect()->route('student.login')->with('success', 'Logout Successfully.');
    }
}

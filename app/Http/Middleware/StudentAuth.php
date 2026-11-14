<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Student;

class StudentAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('student_id')){
            return redirect()->route('student.login')->with('error', 'Please login first.');
        }

        $student = Student::find(session('student_id'));

        if (!$student) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('student.login')->with('error', 'Account not found. Please login again.');
        }

        // Keep student_name synchronized with database
        session(['student_name' => $student->name]);

        return $next($request);
    }
}

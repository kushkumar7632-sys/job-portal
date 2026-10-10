<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;

class StudentController extends Controller
{
    // Show all students
    public function index()
    {
        $students = Student::latest()->get();

        return view('admin.student.index', compact('students'));
    }

    // Show student details
    public function show($id)
    {
        $student = Student::findOrFail($id);

        return view('admin.student.show', compact('student'));
    }

    // Delete student
    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        $student->delete();

        return back()->with('success', 'Student deleted successfully.');
    }
}
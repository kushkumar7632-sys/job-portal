<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Student;

class StudentController extends Controller
{
    // Show all students with search, application counts, and pagination
    public function index(Request $request)
    {
        $query = Student::withCount('applications');

        // Search by student name, email, or phone
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $students = $query->latest()->paginate(10)->withQueryString();

        return view('admin.student.index', compact('students'));
    }

    // Show student details with full application history
    public function show($id)
    {
        $student = Student::withCount('applications')->findOrFail($id);

        // Eager-load application history with related job and company, scoped to this student
        $applications = $student->applications()
            ->with(['job.company'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.student.show', compact('student', 'applications'));
    }

    // Delete student with strict data safety guardrails
    public function destroy($id)
    {
        $student = Student::withCount('applications')->findOrFail($id);

        // STRICT DATA SAFETY: Block deletion if student has any application history
        // to prevent MySQL cascade from erasing employer applicant records
        if ($student->applications_count > 0) {
            return back()->with('error', "Cannot delete student account because {$student->applications_count} submitted application(s) exist in employer records.");
        }

        // Safe deletion inside transaction for students with zero applications
        DB::transaction(function () use ($student) {
            $student->delete();
        });

        return back()->with('success', 'Student deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Tutor;
use App\Models\Course;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.homepage');

    }

    public function student()
    {
        $students = Student::all();
        return view('admin.student', compact('students'));
    }

    public function view($id)
    {
        $students = Student::find($id);
        return view('admin.viewstudent')->with('students', $student);
    }
    public function tutor()
    {
        $tutors = Tutor::all();
        return view('admin.tutor', compact('tutors'));
    }
    public function course()
    {
        $courses = Course::all();
        return view('admin.course', compact('courses'));
    }

    public function payment()
    {
        return view('admin.payment');

    }
}

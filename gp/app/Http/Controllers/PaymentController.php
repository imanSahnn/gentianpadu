<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class PaymentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('payment', compact('students'));
    }
}


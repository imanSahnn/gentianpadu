<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Student;
use App\Models\Course;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    public function index()
    {
        // Retrieve the authenticated user
        $user = Auth::guard('student')->user();

        // Retrieve the user's profile picture filename
        $profilePicture = Student::where('id', $user->id)->value('picture');

        // Pass the authenticated user's profile picture filename to the view
        return view('student.shomepage', compact('profilePicture'));
        return view('student.shomepage', compact('profilePicture'));
    }

    public function edit($id)
    {
        $student = Student::find($id);
        $courses = Course::all();
        return view('admin.editstudent', compact('student', 'courses'));
    }

    public function supdate(Request $request, Student $student)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|confirmed|min:8',
            'email' => 'required|email|max:255|unique:students,email,' . $student->id,
            'ic' => 'required|string|max:20|unique:students,ic,' . $student->id,
            'number' => 'required|string|max:15',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'course_id' => 'required|exists:courses,id',
        ]);

        // Update the student data
        $student->name = $validatedData['name'];
        $student->email = $validatedData['email'];
        $student->ic = $validatedData['ic'];
        $student->number = $validatedData['number'];
        $student->course_id = $validatedData['course_id'];

        // Handle picture upload
        if ($request->hasFile('picture')) {
            $imagePath = $request->file('picture')->store('student_pictures', 'public');
            $student->picture = $imagePath;
        }

        $student->save();

        return redirect()->route('admin.editstudent', $student->id)->with('success', 'Student updated successfully.');
    }


    public function show(Student $student)
    {
        return view('admin.viewstudent', ['student' => $student]);
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        // Delete the student
        $student->delete();

        // Redirect to a specific route with a success message
        return redirect()->route('student')->with('success', 'Student deleted successfully.');
    }
    public function create()
    {
        $courses = Course::all();
        return view('admin.createstudent', ['courses' => $courses]);
    }

    public function slogin()
    {
        return view('student.slogin');
    }

    public function sloginPost(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();

        $credentials = $request->only('email', 'password');

        if (Auth::guard('student')->attempt($credentials)) {
            return redirect()->route('shomepage');
        } else {
            return back()->withInput()->withErrors([
                'email' => 'Invalid email or password.'
            ]);
        }
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'ic_number' => 'required',
            'new_password' => 'required|min:8',
        ]);

        $user = User::where('email', $request->email)
                    ->where('ic_number', $request->ic_number)
                    ->first();

        if ($user) {
            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()->route('login')->with('success', 'Password has been reset successfully.');
        }

        return back()->withErrors(['error' => 'Invalid email or IC number.']);
    }
    public function showTutorList()
    {
        $user = Auth::guard('student')->user();
        $selectedTutor = Tutor::find($user->selected_tutor_id);
        $profilePicture = Student::where('id', $user->id)->value('picture');
        if ($selectedTutor) {
            $tutors = collect([$selectedTutor]);
        } else {
            $tutors = Tutor::where('status', 'active')
                           ->whereHas('course', function($query) use ($user) {
                               $query->where('id', $user->course_id);
                           })
                           ->get();
        }

        return view('student.tutorlist', compact('tutors', 'selectedTutor','profilePicture'));
    }
    public function courselist()
    {
        $user = Auth::guard('student')->user();
        $profilePicture = Student::where('id', $user->id)->value('picture');
        $courses = Course::all();
        return view('student.course_list', compact('courses','profilePicture'));
    }

    public function chooseCourse(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:course,id',
        ]);

        $student = Auth::guard('student')->user();

        if (!$student) {
            return back()->withErrors(['message' => 'User not authenticated']);
        }

        try {
            $student->courses()->attach($request->course_id);
            return back()->with('success', 'Course successfully added!');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Failed to add course: ' . $e->getMessage()]);
        }
    }
}


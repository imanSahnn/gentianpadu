<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tutor;
use App\Models\Course;
use App\Models\Booking;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TutorController extends Controller
{
    public function edit($id)
    {
        $tutor = Tutor::find($id);
        $courses = Course::all();
        return view('admin.edittutor', compact('tutor', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $tutor = Tutor::findOrFail($id);

        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'ic' => 'required|string|max:20',
            'number' => 'required|string|max:15',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'course_id' => 'required|exists:course,id', // Validate course_id
        ]);

        // Update the tutor data
        $tutor->name = $validatedData['name'];
        $tutor->email = $validatedData['email'];
        $tutor->ic = $validatedData['ic'];
        $tutor->number = $validatedData['number'];

        // Handle picture upload
        if ($request->hasFile('picture')) {
            $imagePath = $request->file('picture')->store('tutor_pictures', 'public');
            $tutor->picture = $imagePath;
        }

        // Update the course associated with the tutor
        $tutor->course_id = $validatedData['course_id'];

        $tutor->save();

        return redirect()->route('admin.edittutor', $tutor->id)->with('success', 'Tutor updated successfully.');
    }
    public function show(Tutor $tutor)
    {
        return view('admin.viewtutor', ['tutor' => $tutor]);
    }
    public function destroy(Tutor $tutor)
    {
        // Delete the tutor
        $tutor->delete();

        // Redirect to a specific route with a success message
        return redirect()->route('tutor')->with('success', 'Tutor deleted successfully.');
    }
    public function create()
    {
        $courses = Course::all();
        return view('admin.createtutor', ['courses' => $courses]);
    }
    public function updateStatus($id)
    {
        $tutor = Tutor::findOrFail($id);
        $tutor->status = $tutor->status === 'active' ? 'inactive' : 'active';
        $tutor->save();

        return redirect()->back()->with('success', 'Tutor status updated successfully.');
    }
    public function index()
    {
        $tutors = Tutor::all();
        return view('admin.tutors', compact('tutors'));
    }

    public function tlogin()
    {
        return view('tutor.tlogin');
    }

    public function tloginPost(Request $request)
    {
        // Validate form inputs
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Attempt to authenticate the user
        $credentials = $request->only('email', 'password');
        if (Auth::guard('tutor')->attempt($credentials)) {
            // Authentication successful, redirect to tutor homepage
            return redirect()->route('tutorhomepage');
        } else {
            // Authentication failed, redirect back with error
            return back()->withInput()->withErrors(['email' => 'Invalid email or password.']);
        }
    }
    public function home()
    {
        $timezone = 'Asia/Kuala_Lumpur';
        $tutor = Auth::guard('tutor')->user();
        $profilePicture = Tutor::where('id', $tutor->id)->value('picture');
        // Get the current date and time in Malaysia timezone
        $now = Carbon::now($timezone);

        // Get the start and end of today in Malaysia timezone
        $startOfToday = $now->copy()->startOfDay();
        $endOfToday = $now->copy()->endOfDay();

        // Get the start and end of tomorrow in Malaysia timezone
        $startOfTomorrow = $now->copy()->addDay()->startOfDay();
        $endOfTomorrow = $now->copy()->addDay()->endOfDay();

        // Fetch today's bookings
        $todaysBookings = Booking::whereBetween('date', [$startOfToday, $endOfToday])
                                ->where('status', 'approve')
                                ->get();

        // Fetch tomorrow's bookings
        $tomorrowsBookings = Booking::whereBetween('date', [$startOfTomorrow, $endOfTomorrow])
                                    ->where('status', 'approve')
                                    ->get();

        return view('tutor.tutorhomepage', compact('todaysBookings', 'tomorrowsBookings','profilePicture'));
    }

    public function listStudents()
    {
        $user = Auth::guard('tutor')->user();
        $students = Student::where('selected_tutor_id', $user->id)->get(['picture','id', 'name', 'ic', 'number', 'email']);
        $profilePicture = Tutor::where('id', $user->id)->value('picture');
        return view('tutor.tutorstudent', compact('students','profilePicture'));
    }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutor;
use App\Models\Student;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function showTutorSelectionPage()
    {
        $user = Auth::guard('student')->user();

        $profilePicture = Student::where('id', $user->id)->value('picture');
        $selectedTutorId = $user->selected_tutor_id;
        $hasTutor = !is_null($selectedTutorId);

        if ($hasTutor) {
            $tutors = Tutor::where('id', $selectedTutorId)->get();
        } else {
            $tutors = Tutor::where('status', 'active')
                           ->whereHas('course', function($query) use ($user) {
                               $query->where('id', $user->course_id);
                           })
                           ->get();
        }

        $bookings = Booking::where('student_id', $user->id)
                           ->orderByRaw("FIELD(status, 'approved', 'pending', 'rejected')")
                           ->with('tutor')
                           ->get();

        return view('student.booking', compact('tutors', 'profilePicture', 'hasTutor', 'bookings'));
    }

    public function chooseTutor(Request $request)
    {
        $user = Auth::guard('student')->user();
        $user->selected_tutor_id = $request->tutor_id;
        $user->save();

        return redirect()->route('booking')->with('success', 'Tutor selected successfully!');
    }

    public function bookClass(Request $request)
    {
        $request->validate([
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => 'required|in:08:30,10:00,11:30,14:00,15:30',
        ]);

        $user = Auth::guard('student')->user();
        $selectedTutorId = $user->selected_tutor_id;

        // Check if there is any existing booking for the selected date and time
        $existingBooking = Booking::where('tutor_id', $selectedTutorId)
                                  ->where('date', $request->date)
                                  ->where('time', $request->time)
                                  ->first();

        // If there's an existing booking and its status is not rejected, return error
        if ($existingBooking && $existingBooking->status != 'reject') {
            return redirect()->route('booking')->with('error', 'The selected time slot is already booked.');
        }

        // Create new booking
        Booking::create([
            'student_id' => $user->id,
            'tutor_id' => $selectedTutorId,
            'date' => $request->date,
            'time' => $request->time,
            'status' => 'pending',
        ]);

        return redirect()->route('booking')->with('success', 'Class booked successfully!');
    }

    public function editBooking(Request $request, $bookingId)
    {
        $request->validate([
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => 'required|in:08:30,10:00,11:30,14:00,15:30',
        ]);

        $booking = Booking::findOrFail($bookingId);
        $selectedTutorId = $booking->tutor_id;

        $isBooked = Booking::where('tutor_id', $selectedTutorId)
                           ->where('date', $request->date)
                           ->where('time', $request->time)
                           ->where('id', '!=', $bookingId)
                           ->exists();

        if ($isBooked) {
            return redirect()->route('booking')->with('error', 'The selected time slot is already booked.');
        }

        $booking->date = $request->date;
        $booking->time = $request->time;
        $booking->save();

        return redirect()->route('booking')->with('success', 'Booking updated successfully!');
    }

    public function deleteBooking($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->delete();

        return redirect()->route('booking')->with('success', 'Booking deleted successfully!');
    }
    public function changeBookingStatus(Request $request, $bookingId)
    {
        $request->validate([
            'status' => 'required|in:pending,reject,approve',
        ]);

        $booking = Booking::findOrFail($bookingId);

        // Check if there is any existing approved booking for the same date and time
        $existingApprovedBooking = Booking::where('date', $booking->date)
                                          ->where('time', $booking->time)
                                          ->where('status', 'approve')
                                          ->first();

        // If there's an existing approved booking, prevent approving the current booking
        if ($request->status === 'approve' && $existingApprovedBooking) {
            // Using JavaScript to show a pop-up message
            echo "<script>alert('Another booking for the same date and time is already approved.');</script>";
            return redirect()->back()->with('error', 'Another booking for the same date and time is already approved.');
        }

        // Update booking status
        $booking->status = $request->status;
        $booking->save();

        return redirect()->back()->with('success', 'Booking status updated successfully.');
    }

    public function showTutorBookings()
    {
        $user = Auth::guard('tutor')->user();
        $profilePicture = Tutor::where('id', $user->id)->value('picture');
        $bookings = Booking::where('tutor_id', $user->id)->with('student')->get();

        return view('tutor.tutorbooking', compact('bookings', 'profilePicture'));
    }


        public function showstudent($id)
        {
            $user = Auth::guard('tutor')->user();
            $profilePicture = Tutor::where('id', $user->id)->value('picture');
            $student = Student::findOrFail($id);
            $bookedDates = Booking::where('student_id', $id)->get(['date', 'time', 'attendance_status']);

            return view('tutor.studentdetail', compact('student', 'profilePicture', 'bookedDates'));
        }


    public function updateBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->attendance_status = $request->input('attendance_status');
        $booking->comments = $request->input('comments');
        $booking->save();

        // Fetch the necessary data again to display on the view
        $student = Student::find($booking->student_id);
        $bookedDates = Booking::where('student_id', $booking->student_id)->get();
        $profilePicture = $student->picture;

        return view('tutor.studentdetail', compact('student', 'profilePicture', 'bookedDates'));
    }
}




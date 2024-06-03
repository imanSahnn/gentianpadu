<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function edit(Course $course)
    {
        return view('admin.editcourse', ['course' => $course]);
    }

    public function cupdate(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string|max:15',
            'detail' => 'required|string|max:255',
        ]);

        // Update the tutor data
        $course->name = $validatedData['name'];
        $course->price = $validatedData['price'];
        $course->detail = $validatedData['detail'];
        $course->save();

        return redirect()->route('admin.editcourse', $course->id)->with('success', 'Course updated successfully.');
    }
    public function show(Course $course)
    {
        return view('admin.viewcourse', ['course' => $course]);
    }
    public function destroy(Course $course)
    {
        // Delete the tutor
        $course->delete();

        // Redirect to a specific route with a success message
        return redirect()->route('course')->with('success', 'Tutor deleted successfully.');
    }
    public function create()
    {
        return view('admin.createcourse'); // Ensure this view exists
    }
}

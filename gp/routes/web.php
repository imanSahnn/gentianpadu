<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentHomeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('admin.login');
});

//admin
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login');

Route::get('/homepage', [HomeController::class, 'index'])->name('homepage');
Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/student', [HomeController::class, 'student'])->name('student');
Route::get('/tutor', [HomeController::class, 'tutor'])->name('tutor');
Route::get('/course', [HomeController::class, 'course'])->name('course');
Route::get('/students', [HomeController::class, 'student'])->name('students'); //show student

Route::get('/payment', [HomeController::class, 'payment'])->name('payment');

//tutor
Route::get('/tlogin', [TutorController::class, 'tlogin'])->name('tlogin'); // Tutor login form
Route::post('/tlogin', [TutorController::class, 'tloginPost'])->name('tlogin.save'); // Tutor login form submission
Route::get('/tutor/homepage', [TutorController::class, 'home'])->name('tutorhomepage'); // Tutor homepage

// Route to show the list of students for a specific tutor
Route::get('/tutor/students', [TutorController::class, 'listStudents'])->name('tutor.students');
// Route to show the details of a specific student
Route::get('/student/{id}', [BookingController::class, 'showstudent'])->name('studentdetail');


Route::get('/admin/createtutor', [TutorController::class, 'create'])->name('admin.createtutor');
Route::post('/admin/storetutor', [AuthController::class, 'store'])->name('admin.storetutor');
Route::get('/admin/edittutor/{tutor}', [TutorController::class, 'edit'])->name('admin.edittutor');
Route::post('/admin/update/{tutor}', [TutorController::class, 'update'])->name('admin.update');
Route::get('/admin/viewtutor/{tutor}', [TutorController::class, 'show'])->name('admin.viewtutor');
Route::delete('/admin/destroy/{tutor}', [TutorController::class, 'destroy'])->name('admin.destroy');
Route::patch('tutors/{id}/update-status', [TutorController::class, 'updateStatus'])->name('tutors.updateStatus');
Route::get('admin/tutors', [TutorController::class, 'index'])->name('tutors.index');

Route::group(['middleware' => ['auth:tutor']], function () {
    Route::get('/tutor/bookings', [BookingController::class, 'showTutorBookings'])->name('tutor_bookings');
    Route::get('/tutor/student/{id}', [BookingController::class, 'showStudent'])->name('tutor_student');
    Route::post('/tutor/update-booking/{id}', [BookingController::class, 'updateBooking'])->name('update_booking');
    Route::post('/tutor/change-booking-status/{id}', [BookingController::class, 'changeBookingStatus'])->name('change_booking_status');
});


//student
Route::get('/sregister', [AuthController::class, 'sregister'])->name('sregister'); //untuk get the data from field
Route::post('/sregister', [AuthController::class, 'sregisterPost'])->name('sregister.save'); //pass ke database
Route::get('/slogin', [StudentController::class, 'slogin'])->name('slogin'); //login student
Route::post('/slogin', [StudentController::class, 'sloginPost'])->name('slogin.save'); // check ke db and validation

Route::get('/shomepage', [StudentController::class, 'index'])->name('shomepage'); //bawak ke student homepage

Route::get('/admin/createstudent', [StudentController::class, 'create'])->name('admin.createstudent');
Route::post('/admin/storestudent', [AuthController::class, 'sstore'])->name('admin.storestudent');
Route::get('/admin/editstudent/{student}', [StudentController::class, 'edit'])->name('admin.editstudent');
Route::post('/admin/studentupdate/{student}', [StudentController::class, 'supdate'])->name('admin.supdate');
Route::get('/admin/viewstudent/{student}', [StudentController::class, 'show'])->name('admin.viewstudent');
Route::delete('/admin/destroy/{student}', [StudentController::class, 'destroy'])->name('admin.destroy');

Route::get('student/booking', [BookingController::class, 'create'])->name('student.booking.create');
Route::post('student/booking', [BookingController::class, 'store'])->name('student.booking.store');
Route::post('custom-password-reset', [StudentController::class, 'reset'])->name('custom.password.reset');

Route::get('/tutor-list', [StudentController::class, 'showTutorList'])->name('tutor_list');
Route::post('/submit-review', [StudentController::class, 'submitReview'])->name('submit_review');


Route::middleware(['auth:student'])->group(function () {
    Route::get('/courses', [StudentController::class, 'courselist'])->name('course_list');
    Route::post('/choose-course', [StudentController::class, 'chooseCourse'])->name('choose_course');
});

Route::group(['middleware' => ['auth:student']], function () {
    Route::get('/book-tutor', [BookingController::class, 'showBookingForm'])->name('bookings');
    Route::post('/fetch-available-tutors', [BookingController::class, 'fetchAvailableTutors'])->name('fetch_available_tutors');
    Route::post('/create-booking', [BookingController::class, 'bookClass'])->name('create_booking');
    Route::post('/choose-tutor', [BookingController::class, 'chooseTutor'])->name('choose_tutor');
    Route::post('/edit-booking/{id}', [BookingController::class, 'editBooking'])->name('edit_booking');
    Route::delete('/delete-booking/{id}', [BookingController::class, 'deleteBooking'])->name('delete_booking');
});




//course
Route::get('/admin/createcourse', [CourseController::class, 'create'])->name('admin.createcourse');
Route::post('/admin/storecourse', [AuthController::class, 'cstore'])->name('admin.storecourse');

// Edit and update course routes
Route::get('/admin/editcourse/{course}', [CourseController::class, 'edit'])->name('admin.editcourse');
Route::post('/admin/courseupdate/{course}', [CourseController::class, 'cupdate'])->name('admin.cupdate');

// View and delete course routes
Route::get('/admin/viewcourse/{course}', [CourseController::class, 'show'])->name('admin.viewcourse');
Route::delete('/admin/destroy/{course}', [CourseController::class, 'destroy'])->name('admin.destroycourse');

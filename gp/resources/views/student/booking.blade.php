<!-- resources/views/student/booking.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Book a Tutor</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
@extends('student.layout')

@section('title', 'Book a Tutor')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-3">
            @include('student.sidebar')
        </div>
        <div class="col-md-9">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('fetch_available_tutors') }}" method="POST" class="mb-4">
                @csrf
                <div class="form-group row">
                    <label for="course" class="col-sm-2 col-form-label">Course</label>
                    <div class="col-sm-10">
                        <select id="course" name="course_id" class="form-control" required>
                            <option value="">Select a Course</option>
                            @foreach($chosenCourses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date" class="col-sm-2 col-form-label">Choose a Date:</label>
                    <div class="col-sm-10">
                        <input type="text" id="date" name="date" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="time" class="col-sm-2 col-form-label">Choose a Time:</label>
                    <div class="col-sm-10">
                        <select name="time" id="time" class="form-control" required>
                            <option value="">Select a Time</option>
                            <option value="08:30">08:30 AM - 10:00 AM</option>
                            <option value="10:00">10:00 AM - 11:30 AM</option>
                            <option value="11:30">11:30 AM - 01:00 PM</option>
                            <option value="14:00">02:00 PM - 03:30 PM</option>
                            <option value="15:30">03:30 PM - 05:00 PM</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>

            @if(isset($availableTutors))
                <h2 class="text-center mb-4">Available Tutors</h2>
                <form action="{{ route('create_booking') }}" method="POST">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ request('course_id') }}">
                    <input type="hidden" name="date" value="{{ request('date') }}">
                    <input type="hidden" name="time" value="{{ request('time') }}">
                    <div class="row">
                        @foreach($availableTutors as $tutor)
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $tutor->name }}</h5>
                                        <p class="card-text">Expertise: {{ $tutor->expertise }}</p>
                                        <button type="submit" name="tutor_id" value="{{ $tutor->id }}" class="btn btn-primary">Choose</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </form>
            @endif

            <h2 class="text-center mt-5">Your Bookings</h2>
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Tutor Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        <tr class="status-{{ strtolower($booking->status) }}">
                            <td>{{ $booking->tutor->name }}</td>
                            <td>{{ $booking->date }}</td>
                            <td>{{ $booking->time }}</td>
                            <td>{{ ucfirst($booking->status) }}</td>
                            <td>
                                @if(\Carbon\Carbon::now()->lt(\Carbon\Carbon::parse($booking->date)))
                                    <button class="btn btn-warning" onclick="editBooking({{ $booking->id }}, '{{ $booking->date }}', '{{ $booking->time }}')">Edit</button>
                                    <button class="btn btn-danger" onclick="confirmDelete({{ $booking->id }})">Delete</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Edit Booking Modal -->
            <div id="editBookingModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('editBookingModal')">&times;</span>
                    <h2>Edit Booking</h2>
                    <form id="editBookingForm" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="edit_date">Choose a Date:</label>
                            <input type="text" id="edit_date" name="date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_time">Choose a Time:</label>
                            <select name="time" id="edit_time" class="form-control" required>
                                <option value="">Select a Time</option>
                                <option value="08:30">08:30 AM - 10:00 AM</option>
                                <option value="10:00">10:00 AM - 11:30 AM</option>
                                <option value="11:30">11:30 AM - 01:00 PM</option>
                                <option value="14:00">02:00 PM - 03:30 PM</option>
                                <option value="15:30">03:30 PM - 05:00 PM</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>

            <!-- Delete Booking Modal -->
            <div id="deleteBookingModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal('deleteBookingModal')">&times;</span>
                    <h2>Confirm Deletion</h2>
                    <p>Are you sure you want to delete this booking?</p>
                    <button id="confirmDeleteBtn" class="btn btn-danger">Delete</button>
                    <button class="btn btn-secondary" onclick="closeModal('deleteBookingModal')">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(function() {
        // Initialize datepicker
        $("#date, #edit_date").datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: 1,
            beforeShowDay: function(date) {
                var day = date.getDay();
                return [(day != 0), '']; // Disable Sundays
            }
        });
    });

    function editBooking(id, date, time) {
        $('#edit_date').val(date);
        $('#edit_time').val(time);
        $('#editBookingForm').attr('action', '{{ url("edit-booking") }}/' + id);
        $('#editBookingModal').show();
    }

    function confirmDelete(id) {
        $('#confirmDeleteBtn').attr('onclick', 'deleteBooking(' + id + ')');
        $('#deleteBookingModal').show();
    }

    function deleteBooking(id) {
        $.ajax({
            url: '/delete-booking/' + id,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                // Reload the page after successful deletion
                location.reload();
            }
        });
    }

    function closeModal(modalId) {
        $('#' + modalId).hide();
    }
</script>
</body>
</html>

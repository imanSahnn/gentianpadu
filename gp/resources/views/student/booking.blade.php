<!DOCTYPE html>
<html>
<head>
    <title>Book a Tutor</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        .ui-datepicker {
            z-index: 1000 !important; /* Ensure datepicker is above other elements */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        .status-approved {
            background-color: #d4edda; /* green */
            color: #155724;
        }
        .status-pending {
            background-color: #fff3cd; /* yellow */
            color: #856404;
        }
        .status-rejected {
            background-color: #f8d7da; /* red */
            color: #721c24;
        }
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
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
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
        /* Sidebar styles */
        .sidebar {
            background-color: #343a40;
            color: #fff;
            min-height: 100vh;
            padding-top: 20px;
        }
        .sidebar a {
            color: #fff;
            padding: 10px;
            text-decoration: none;
            display: block;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
    </style>
</head>
<body>
@extends('student.layout')

@section('title', 'Book a Tutor')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 sidebar">
                <!-- Include your sidebar content here -->
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

                @if($hasTutor)
                    <h2>Your Selected Tutor</h2>
                    @foreach($tutors as $tutor)
                        <div>
                            <h3>{{ $tutor->name }}</h3>
                            <p>{{ $tutor->bio }}</p>
                        </div>
                    @endforeach

                    <form action="{{ route('book_class') }}" method="POST">
                        @csrf
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
                                    <option value="11:30">11:30 AM - 13:00 PM</option>
                                    <option value="14:00">14:00 PM - 15:30 PM</option>
                                    <option value="15:30">15:30 PM - 17:00 PM</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn btn-primary">Book Class</button>
                            </div>
                        </div>
                    </form>

                    <h2>Your Bookings</h2>
                    <table class="table table-striped">
                        <thead>
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
                                        <button class="btn btn-warning" onclick="editBooking({{ $booking->id }}, '{{ $booking->date }}', '{{ $booking->time }}')">Edit</button>
                                        <button class="btn btn-danger" onclick="confirmDelete({{ $booking->id }})">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <form action="{{ route('choose_tutor') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="tutor_id">Choose a Tutor:</label>
                            <select name="tutor_id" id="tutor_id" class="form-control" required>
                                <option value="">Select a Tutor</option>
                                @foreach($tutors as $tutor)
                                    <option value="{{ $tutor->id }}">{{ $tutor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Select Tutor</button>
                    </form>
                @endif
            </div>
        </div>

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
                            <option value="11:30">11:30 AM - 13:00 PM</option>
                            <option value="14:00">14:00 PM - 15:30 PM</option>
                            <option value="15:30">15:30 PM - 17:00 PM</option>
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
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(function() {
        // Get current date and time
        var now = new Date();
        var currentHour = now.getHours();

        // Get tomorrow's date
        var tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);

        // Set the minimum selectable date to tomorrow if current time is before 4:00 PM Malaysia time
        var minDate = (currentHour < 16) ? tomorrow : now;

        $("#date, #edit_date").datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: minDate,
            beforeShowDay: function(date) {
                var day = date.getDay();
                return [(day != 0), '']; // Disable Sundays (day == 0)
            }
        });
    });

    function editBooking(id, date, time) {
        $('#edit_date').val(date);
        $('#edit_time').val(time);
        $('#editBookingForm').attr('action', '/edit-booking/' + id);
        $('#editBookingModal').show();
    }

    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this booking?")) {
            deleteBooking(id);
            // Reload the page after deletion
            location.reload();
        }
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

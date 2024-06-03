<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
            padding-bottom: 150px;
            padding-left: 2rem;
            padding-right: 2rem;
        }

        @media (min-width: 768px) {
            .grid-container {
                grid-template-columns: 2fr 1fr;
                grid-template-rows: auto;
            }
        }

        .profile-container,
        .booked-dates,
        .empty-section {
            background-color: #fff;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .profile-details {
            text-align: center;
            margin-bottom: 2rem;
        }

        .profile-details img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
        }

        .profile-details p {
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }

        .booked-dates ul {
            list-style-type: disc;
            padding-left: 1.5rem;
            margin-bottom: 2rem;
        }

        h2 {
            font-size: 1.75rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .booking-item {
            margin-bottom: 1rem;
            cursor: pointer;
        }

        .booking-date {
            font-weight: bold;
        }

        .booking-time {
            color: #555;
        }

        .booking-status {
            color: green;
        }

        .booking-status.absent {
            color: red;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            margin: auto;
            padding: 10px;
            border: 1px solid #888;
            width: 90%;
            max-width: 600px;
            border-radius: 0.5rem;
        }

        .modal-header, .modal-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            margin: 0;
        }

        .modal-footer {
            margin-top: 1rem;
        }

        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .empty-section {
            text-align: center;
            color: #aaa;
        }

        /* Full-page dropdown */
        .full-page-dropdown {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .full-page-dropdown select {
            width: 80%;
            height: 50px;
            font-size: 1.25rem;
            padding: 0.5rem;
            border-radius: 0.5rem;
            border: 1px solid #ccc;
            background-color: #fff;
            color: #333;
        }

        .full-page-dropdown button {
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.5rem;
            background-color: #4a90e2;
            color: #fff;
            font-size: 1rem;
            cursor: pointer;
        }

        .full-page-dropdown img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
        }

        .full-page-dropdown a {
            font-size: 1.25rem;
            margin-top: 1rem;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-100">
    @extends('tutor.layout')

    @section('title', 'Student Details')

    @section('content')
    <div class="max-w-7xl mx-auto mt-8 grid-container">
        <div class="profile-container">
            <div class="profile-details">
                <h2 class="text-3xl font-bold mb-6">Student Details</h2>
                <img src="{{ asset('storage/' . $student->picture) }}" alt="Profile Picture" class="mx-auto mb-6">
                <p class="text-xl font-medium">Name: {{ $student->name }}</p>
                <p class="text-xl">Phone Number: {{ $student->number }}</p>
                <p class="text-xl">Email: {{ $student->email }}</p>
            </div>
        </div>
        <div class="booked-dates">
            <h2 class="text-3xl font-bold mb-6">Booked Dates</h2>
            <ul class="list-disc pl-8 mb-6">
                @foreach ($bookedDates as $booking)
                    <li class="booking-item mb-4 cursor-pointer" data-booking-id="{{ $booking->id }}" onclick="openModal('{{ $booking->id }}', '{{ $booking->date }}', '{{ $booking->time }}', '{{ $booking->attendance_status }}')">
                        <span class="booking-date text-xl font-medium">{{ $booking->date }}</span> at
                        <span class="booking-time text-gray-600">{{ $booking->time }}</span> -
                        <span class="booking-status {{ $booking->attendance_status == 'absent' ? 'text-red-600' : 'text-green-600' }}">
                            {{ ucfirst($booking->attendance_status) }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="empty-section">
            <h2 class="text-3xl font-bold mb-6">Additional Information</h2>
            This section is intentionally left blank.
        </div>
    </div>

    <div id="bookingModal" class="modal flex items-center justify-center">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="text-2xl font-bold">Booking Details</h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <form method="POST" action="/update-booking" id="updateBookingForm">
                @csrf
                <input type="hidden" name="booking_id" id="bookingId">
                <div class="modal-body mt-4">
                    <p class="mb-2"><strong>Date:</strong> <span id="modalDate"></span></p>
                    <p class="mb-2"><strong>Time:</strong> <span id="modalTime"></span></p>
                    <p class="mb-2"><strong>Attendance Status:</strong>
                        <div class="relative">
                            <input type="text" readonly class="ml-2 p-2 border rounded w-full" id="attendanceStatusText" onclick="showDropdown()">
                        </div>
                    </p>
                    <p class="mb-2"><strong>Comments:</strong></p>
                    <textarea name="comments" rows="4" class="w-full p-2 border rounded"></textarea>
                </div>
                <div class="modal-footer mt-4">
                    <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Close</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div id="fullPageDropdown" class="full-page-dropdown flex">
        <div class="flex flex-col items-center">
            <img src="{{ asset('storage/' . $student->picture) }}" alt="Profile Picture">
            <a href="#">Home</a>
            <a href="#">Booking</a>
            <a href="#">Profile</a>
            <a href="#">Tutor</a>
            <select id="attendanceStatus" class="mt-4 w-80 p-2 border rounded">
                <option value="present">Present</option>
                <option value="absent">Absent</option>
            </select>
            <button onclick="selectAttendanceStatus()">Select</button>
        </div>
    </div>
    @endsection

    <script>
let currentBookingId;

function openModal(id, date, time, status) {
    currentBookingId = id;
    document.getElementById('modalDate').innerText = date;
    document.getElementById('modalTime').innerText = time;
    document.getElementById('bookingId').value = id;
    document.getElementById('attendanceStatusText').value = status;
    document.getElementById('bookingModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('bookingModal').style.display = 'none';
}

function showDropdown() {
    document.getElementById('fullPageDropdown').style.display = 'flex';
}

function selectAttendanceStatus() {
    const dropdown = document.getElementById('attendanceStatus');
    const statusText = document.getElementById('attendanceStatusText');
    statusText.value = dropdown.value;
    document.getElementById('fullPageDropdown').style.display = 'none';
}
    </script>
</body>
</html>

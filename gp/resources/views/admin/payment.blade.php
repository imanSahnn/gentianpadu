<!-- resources/views/payment.blade.php -->

@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Student Payments</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Course</th>
                <th>Total Payment</th>
                <th>Payment Made</th>
                <th>Pending Payment</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student->name }}</td>
                <td>{{ $student->course }}</td>
                <td>{{ $student->total_payment }}</td>
                <td>{{ $student->payment_made }}</td>
                <td>{{ $student->total_payment - $student->payment_made }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

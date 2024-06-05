@extends('tutor.layout')

@section('title', 'Homepage')

@section('content')
<div class="container">
    <h1>Students List</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>IC</th>
                <th>Number</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->ic }}</td>
                    <td>{{ $student->number }}</td>
                    <td>{{ $student->email }}</td>
                    <td><a href="{{ route('studentdetail', ['id' => $student->id]) }}" class="btn btn-primary">View Booking</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

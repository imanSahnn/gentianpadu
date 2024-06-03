<!DOCTYPE html>
<html>
<head>
    <title>Tutor</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @extends('admin.layout')

    @section('title', 'Tutor Page')

    @section('content')
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1>Tutor Page</h1>
                </div>
                <div class="col text-right">
                    <a href="{{ route('admin.createtutor') }}" class="btn btn-primary">Add New Tutor</a>
                </div>
            </div>

            <p>This is the content of the tutor page.</p>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Profile Picture</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Course</th> <!-- New column for the associated course -->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tutors as $tutor)
                            <tr>
                                <td>{{ $tutor->id }}</td>
                                <td>
                                    @if($tutor->picture)
                                        <img src="{{ asset('storage/' . $tutor->picture) }}" alt="Profile Picture" width="150">
                                    @else
                                        No Picture
                                    @endif
                                </td>
                                <td>{{ $tutor->name }}</td>
                                <td>{{ $tutor->email }}</td>
                                <td>{{ $tutor->number }}</td>
                                <td>{{ $tutor->course->name ?? 'No Course' }}</td> <!-- Display associated course -->
                                <td>{{ ucfirst($tutor->status) }}</td> <!-- Display status -->
                                <td>
                                    <form action="{{ route('tutors.updateStatus', $tutor->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $tutor->status === 'active' ? 'btn-warning' : 'btn-success' }}">
                                            {{ $tutor->status === 'active' ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.viewtutor', [$tutor->id]) }}" class="btn btn-sm btn-primary">View</a>
                                    <a href="{{ route('admin.edittutor', [$tutor->id]) }}" class="btn btn-sm btn-info">Edit</a>
                                    <form action="{{ route('admin.destroy', $tutor->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this tutor?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endsection
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>course</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @extends('admin.layout')

    @section('title', 'course Page')

    @section('content')
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1>course Page</h1>
                </div>
                <div class="col text-right">
                    <a href="{{ route('admin.createcourse') }}" class="btn btn-primary">Add New course</a>
                </div>
            </div>

            <p>This is the content of the student page.</p>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Picture</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Detail</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $course)
                            <tr>
                                <td>{{ $course->id }}</td>
                                <td>{{ $course->picture }}</td>
                                <td>{{ $course->name }}</td>
                                <td>{{ $course->price }}</td>
                                <td>{{ $course->detail }}</td>
                                <td>
                                    <a href="{{ route('admin.viewcourse', [$course->id]) }}" class="btn btn-sm btn-primary">View</a>
                                    <a href="{{ route('admin.editcourse', [$course->id]) }}" class="btn btn-sm btn-info">Edit</a>
                                    <form action="{{ route('admin.destroycourse', $course->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this course?');">
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

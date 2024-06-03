<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-100">
    <!-- Include Sidebar -->
    @include('student.sidebar')

    <!-- Main Content -->
    <div class="md:ml-64">
        @yield('content')
    </div>
</body>

</html>

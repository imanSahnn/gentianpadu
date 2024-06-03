<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Homepage')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
        }
        .sidebar {
            width: 280px;
            height: 100vh;
            background-color: #d97d1b;
            color: white;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
        .sidebar hr {
            border-top-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar a {
            color: white;
        }
        .sidebar a:hover {
            color: #adb5bd;
        }
        .sidebar .nav-link.active {
            background-color: #495057;
        }

    </style>
</head>
<body>
    <div class="sidebar d-flex flex-column flex-shrink-0 p-3">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-light text-decoration-none">
            <i class="bi bi-bootstrap-fill"></i>
            <span class="fs-4 ms-2">Brand</span>
        </a>
        <hr>
        <div class="d-flex flex-column align-items-center mb-3">
            <img src="https://via.placeholder.com/150" alt="avatar" class="rounded-circle" width="100" height="100">
            <h4 class="mt-2">John Doe</h4>
            <p class="text-muted">john.doe@example.com</p>
        </div>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ route('homepage') }}" class="nav-link {{ request()->is('homepage') ? 'active' : '' }}">
                    <i class="bi bi-house-fill"></i>
                    Home
                </a>
            </li>
            <li>
                <a href="{{ route('student') }}" class="nav-link {{ request()->is('student') ? 'active' : '' }}">
                    <i class="bi bi-person-fill"></i>
                    Student
                </a>
            </li>
            <li>
                <a href="{{ route('tutor') }}" class="nav-link {{ request()->is('tutor') ? 'active' : '' }}">
                    <i class="bi bi-person-badge-fill"></i>
                    Tutor
                </a>
            </li>
            <li>
                <a href="{{ route('course') }}" class="nav-link {{ request()->is('course') ? 'active' : '' }}">
                    <i class="bi bi-book-fill"></i>
                    Course
                </a>
            </li>
        </ul>
        <hr>
        <a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

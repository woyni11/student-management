<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'School Management System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">🏫 School Management</a>

            @auth
                <div class="d-flex align-items-center">
                    <ul class="navbar-nav flex-row me-3">
                        @if (auth()->user()->isAdmin())
                            <li class="nav-item me-3"><a class="nav-link text-white" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="nav-item me-3"><a class="nav-link text-white" href="{{ route('admin.students.index') }}">Students</a></li>
                            <li class="nav-item me-3"><a class="nav-link text-white" href="{{ route('admin.teachers.index') }}">Teachers</a></li>
                            <li class="nav-item me-3"><a class="nav-link text-white" href="{{ route('admin.courses.index') }}">Courses</a></li>
                            <li class="nav-item me-3"><a class="nav-link text-white" href="{{ route('admin.reports.index') }}">Reports</a></li>
                        @elseif (auth()->user()->isTeacher())
                            <li class="nav-item me-3"><a class="nav-link text-white" href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
                            <li class="nav-item me-3"><a class="nav-link text-white" href="{{ route('teacher.students.index') }}">My Students</a></li>
                            <li class="nav-item me-3"><a class="nav-link text-white" href="{{ route('teacher.attendance.index') }}">Attendance</a></li>
                            <li class="nav-item me-3"><a class="nav-link text-white" href="{{ route('teacher.grades.index') }}">Grades</a></li>
                        @elseif (auth()->user()->isStudent())
                            <li class="nav-item me-3"><a class="nav-link text-white" href="{{ route('student.profile') }}">Profile</a></li>
                            <li class="nav-item me-3"><a class="nav-link text-white" href="{{ route('student.courses') }}">My Course</a></li>
                            <li class="nav-item me-3"><a class="nav-link text-white" href="{{ route('student.attendance') }}">Attendance</a></li>
                            <li class="nav-item me-3"><a class="nav-link text-white" href="{{ route('student.grades') }}">Grades</a></li>
                        @endif
                    </ul>

                    <span class="text-white-50 me-3">{{ auth()->user()->name }} ({{ auth()->user()->role }})</span>

                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light">Logout</button>
                    </form>
                </div>
            @endauth
        </div>
    </nav>

    <div class="container">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

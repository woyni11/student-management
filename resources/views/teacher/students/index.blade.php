@extends('layouts.app')

@section('title', 'My Students')

@section('content')

    <h3 class="mb-3">My Students</h3>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead><tr><th>Name</th><th>Email</th><th>Courses</th><th>Attendance Rate</th></tr></thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td>{{ $student->user->name }}</td>
                            <td>{{ $student->user->email }}</td>
                            <td>
                                @forelse ($student->courses as $c)
                                    <span class="badge bg-light text-dark border">{{ $c->code }}</span>
                                @empty
                                    —
                                @endforelse
                            </td>
                            <td>{{ $student->attendancePercentage() }}%</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center py-4">No students in your courses yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $students->links() }}</div>

@endsection

@extends('layouts.app')

@section('title', 'My Attendance')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>My Attendance</h3>
        <span class="badge bg-{{ $percentage >= 75 ? 'success' : 'danger' }} fs-6">{{ $percentage }}% present</span>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead><tr><th>Date</th><th>Course</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse ($records as $r)
                        <tr>
                            <td>{{ $r->date->format('d M, Y') }}</td>
                            <td>{{ $r->course->name }}</td>
                            <td><span class="badge bg-{{ $r->status === 'present' ? 'success' : 'danger' }}">{{ ucfirst($r->status) }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center py-4">No attendance records yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $records->links() }}</div>

@endsection

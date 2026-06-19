@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

    <h3 class="mb-3">My Profile</h3>

    @if ($student)
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <tr><th style="width:200px;">Name</th><td>{{ $student->user->name }}</td></tr>
                    <tr><th>Email</th><td>{{ $student->user->email }}</td></tr>
                    <tr><th>Phone</th><td>{{ $student->phone ?? '—' }}</td></tr>
                    <tr><th>Date of Birth</th><td>{{ $student->dob?->format('d M, Y') ?? '—' }}</td></tr>
                    <tr><th>Address</th><td>{{ $student->address ?? '—' }}</td></tr>
                    <tr><th>Course</th><td>{{ $student->course->name ?? 'Not enrolled yet' }}</td></tr>
                    <tr><th>Course Teacher</th><td>{{ $student->course->teacher->user->name ?? '—' }}</td></tr>
                    <tr>
                        <th>Status</th>
                        <td><span class="badge bg-{{ $student->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($student->status) }}</span></td>
                    </tr>
                </table>
            </div>
        </div>
    @else
        <p class="text-muted">No student profile found for your account.</p>
    @endif

@endsection

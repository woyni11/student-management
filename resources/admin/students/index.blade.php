@extends('layouts.app')

@section('title', 'Students')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Students</h3>
        <a href="{{ route('admin.students.create') }}" class="btn btn-primary">+ Add Student</a>
    </div>

    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Search by name or email...">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </form>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td>{{ $student->user->name }}</td>
                            <td>{{ $student->user->email }}</td>
                            <td>{{ $student->course->name ?? '—' }}</td>
                            <td>
                                <span class="badge bg-{{ $student->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($student->status) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.students.show', $student) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this student?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4">No students found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $students->links() }}</div>

@endsection

@extends('layouts.app')

@section('title', 'Teachers')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Teachers</h3>
        <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">+ Add Teacher</a>
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
                        <th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>Department</th><th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($teachers as $teacher)
                        <tr>
                            <td>{{ $teacher->id }}</td>
                            <td>{{ $teacher->user->name }}</td>
                            <td>{{ $teacher->user->email }}</td>
                            <td>{{ $teacher->phone }}</td>
                            <td>{{ $teacher->department ?? '—' }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.teachers.edit', $teacher) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this teacher?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4">No teachers found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $teachers->links() }}</div>

@endsection

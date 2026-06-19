@extends('layouts.app')

@section('title', 'Grades Report')

@section('content')

    <h3 class="mb-1">Grades Report</h3>
    <p class="text-muted">{{ $course->name }} ({{ $course->code }})</p>

    @php $maxTotal = array_sum(\App\Models\Grade::WEIGHTS); @endphp

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Assessments Recorded</th>
                        <th>Total Score (out of {{ $maxTotal }})</th>
                        <th>Grade / Remark</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        @php
                            $total  = $student->grades->sum(fn($g) => $g->weightedScore());
                            $remark = \App\Models\Grade::remark($total);
                        @endphp
                        <tr>
                            <td>{{ $student->user->name }}</td>
                            <td>{{ $student->grades->count() }} / 5</td>
                            <td>
                                <span class="badge bg-{{ in_array($remark, ['F','D']) ? 'danger' : (in_array($remark, ['C-','C','C+']) ? 'warning' : 'success') }}">
                                    {{ $total }} / {{ $maxTotal }}
                                </span>
                            </td>
                            <td>
                                <strong>{{ $remark }}</strong>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center py-4">No students enrolled.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary mt-3">Back to Reports</a>

@endsection

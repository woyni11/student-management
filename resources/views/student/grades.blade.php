@extends('layouts.app')

@section('title', 'My Grades')

@section('content')

    <h3 class="mb-3">My Grades</h3>

    @forelse ($gradesByCourse as $courseId => $data)

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>{{ $data['course']->name }} ({{ $data['course']->code }})</strong>
                <span class="badge fs-6
                    @if(in_array($data['remark'], ['F','D'])) bg-danger
                    @elseif(in_array($data['remark'], ['C-','C','C+'])) bg-warning text-dark
                    @else bg-success
                    @endif">
                    Total: {{ $data['total'] }} / {{ $maxTotal }} &mdash; {{ $data['remark'] }}
                </span>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Assessment</th>
                            <th>Out of</th>
                            <th>Score</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['grades'] as $g)
                            <tr>
                                <td>{{ $g->assessment }}</td>
                                <td>{{ $g->weight() }}</td>
                                <td>{{ $g->score }}</td>
                                <td>{{ $g->remarks ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td colspan="2">Total Score</td>
                            <td>{{ $data['total'] }}</td>
                            <td>Grade: {{ $data['remark'] }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    @empty
        <p class="text-muted">No grades recorded yet.</p>
    @endforelse

@endsection
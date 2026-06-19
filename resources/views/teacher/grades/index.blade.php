@extends('layouts.app')

@section('title', 'Grades')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Grades</h3>
        <a href="{{ route('teacher.grades.create', ['course_id' => $courseId]) }}" class="btn btn-primary">+ Enter / Update Grades</a>
    </div>

    <form method="GET" class="mb-3 col-md-4">
        <select name="course_id" class="form-select" onchange="this.form.submit()">
            @foreach ($courses as $c)
                <option value="{{ $c->id }}" {{ $courseId === $c->id ? 'selected' : '' }}>
                    {{ $c->name }} ({{ $c->code }})
                </option>
            @endforeach
        </select>
    </form>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @php $assessments = array_keys(\App\Models\Grade::WEIGHTS); @endphp

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th rowspan="2" class="align-middle">Student</th>
                    @foreach (\App\Models\Grade::WEIGHTS as $name => $max)
                        <th class="text-center">
                            {{ $name }}<br>
                            <small class="text-muted fw-normal">/ {{ $max }}</small>
                        </th>
                    @endforeach
                    <th class="text-center">Total<br><small class="text-muted fw-normal">/ {{ array_sum(\App\Models\Grade::WEIGHTS) }}</small></th>
                    <th class="text-center">Grade</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($studentGrades as $row)
                    <tr>
                        <td class="fw-semibold">{{ $row['name'] }}</td>
                        @foreach ($assessments as $name)
                            <td class="text-center">
                                @if (isset($row['scores'][$name]))
                                    {{ $row['scores'][$name]['score'] }}
                                    @if ($row['scores'][$name]['remark'])
                                        <br><small class="text-muted">{{ $row['scores'][$name]['remark'] }}</small>
                                    @endif
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                        @endforeach
                        <td class="text-center fw-bold">{{ $row['total'] }}</td>
                        <td class="text-center">
                            <span class="badge bg-{{ in_array($row['grade'], ['F','D']) ? 'danger' : (in_array($row['grade'], ['C-','C','C+']) ? 'warning' : 'success') }}">
                                {{ $row['grade'] }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('teacher.grades.create', ['course_id' => $courseId]) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ 3 + count($assessments) }}" class="text-center py-4 text-muted">No grades recorded yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection

Set-Content resources\views\student\grades.blade.php -Encoding UTF8 -Value '@extends(''layouts.app'')

@section(''title'', ''My Grades'')

@section(''content'')

    <h3 class="mb-3">My Grades</h3>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Assessment</th>
                        <th>Out of</th>
                        <th>Score</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($grades as $g)
                        <tr>
                            <td>{{ $g->course->name }}</td>
                            <td>{{ $g->assessment }}</td>
                            <td>{{ $g->weight() }}</td>
                            <td>{{ $g->score }}</td>
                            <td>{{ $g->remarks ?? "—" }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-4">No grades recorded yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $grades->links() }}</div>

@endsection'
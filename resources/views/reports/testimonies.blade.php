@extends('layout.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Testimonies</h2>

    <!-- Search Box -->
    <input type="text" id="searchTestimonies" class="form-control mb-3" placeholder="Search Testimonies...">

    <!-- Testimonies Table -->
    <table class="table table-striped table-hover" id="testimonyTable">
        <thead class="table-info">
            <tr>
                <th>Type</th>
                <th>Text</th>
                <th>File</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody id="testimonyTableBody">
            @foreach($testimonies as $testimony)
            <tr>
                <td>{{ $testimony->testimony_type }}</td>
                <td>{{ Str::limit($testimony->text, 100) }}</td>
                <td>
                    @if($testimony->file_path)
                    <a href="{{ asset('storage/' . $testimony->file_path) }}" target="_blank">View File</a>
                    @else
                    N/A
                    @endif
                </td>
                <td>{{ $testimony->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $testimonies->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#searchTestimonies').on('keyup', function() {
            let query = $(this).val();
            $.ajax({
                url: "{{ route('reports.testimonies') }}",
                type: 'GET',
                data: { search: query },
                success: function(data) {
                    $('#testimonyTableBody').html(data.html);
                }
            });
        });
    });
</script>
@endsection

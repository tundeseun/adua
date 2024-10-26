@extends('layout.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Prayers</h2>

    <!-- Search Box -->
    <input type="text" id="searchPrayers" class="form-control mb-3" placeholder="Search Prayers...">

    <!-- Prayers Table -->
    <table class="table table-bordered table-hover" id="prayerTable">
        <thead class="table-success">
            <tr>
                <th>Prayer Type</th>
                <th>Text</th>
                <th>File</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody id="prayerTableBody">
            @foreach($prayers as $prayer)
            <tr>
                <td>{{ $prayer->prayer_type }}</td>
                <td>{{ Str::limit($prayer->text, 100) }}</td>
                <td>
                    @if($prayer->file_path)
                    <a href="{{ asset('storage/' . $prayer->file_path) }}" target="_blank">View File</a>
                    @else
                    N/A
                    @endif
                </td>
                <td>{{ $prayer->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $prayers->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#searchPrayers').on('keyup', function() {
            let query = $(this).val();
            $.ajax({
                url: "{{ route('reports.prayers') }}",
                type: 'GET',
                data: { search: query },
                success: function(data) {
                    $('#prayerTableBody').html(data.html);
                }
            });
        });
    });
</script>
@endsection

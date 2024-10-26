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

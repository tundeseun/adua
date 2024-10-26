@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h3>Send a Voice Prayer</h3>

    <!-- Display validation errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Prayer form -->
    <form action="{{ url('prayer/voice') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- User ID input -->
        <div class="form-group mb-3">
            <label for="user_id">User ID</label>
            <input type="number" name="user_id" id="user_id" class="form-control" required>
        </div>

        <!-- Voice Note file input -->
        <div class="form-group mb-3">
            <label for="voice_note">Voice Note (Optional - MP3 or MP4)</label>
            <input type="file" name="voice_note" id="voice_note" class="form-control" accept=".mp3, .mp4">
        </div>

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary">Send Prayer</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.querySelector('form').onsubmit = async function(event) {
        event.preventDefault();

        // Create a FormData object with the form data
        const formData = new FormData(this);

        try {
            // Submit the form data using fetch API
            const response = await fetch("{{ url('prayer/voice') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            // Check if the response is successful
            const result = await response.json();
            if (response.ok) {
                alert(result.message); // Success message
            } else {
                alert(result.errors.join('\n')); // Error messages
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        }
    };
</script>
@endsection

<!-- resources/views/admin/live-stream.blade.php -->
@extends('layout.app')
@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h2>Live Stream Admin Interface</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.live-stream.update') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="youtube_link">YouTube Live Stream Link:</label>
            <input type="url" name="youtube_link" id="youtube_link" class="form-control" value="{{ $liveStream->youtube_link ?? '' }}" required>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Update Link</button>
    </form>

    @if($liveStream)
        <h3 class="mt-4">Current Live Stream</h3>
        <iframe width="560" height="315" src="{{ $liveStream->youtube_link }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    @else
        <p class="mt-4">No live stream link available.</p>
    @endif
</div>
@endsection

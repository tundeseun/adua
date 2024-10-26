@extends('layout.app')

@section('content')
<div class="container">
    <h2>Create Call Schedule</h2>
    <form action="{{ route('callschedule.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="scheduled_date">Date:</label>
            <input type="date" class="form-control" id="scheduled_date" name="scheduled_date" required>
        </div>
        
        <div class="form-group">
            <label for="scheduled_time">Time:</label>
            <input type="time" class="form-control" id="scheduled_time" name="scheduled_time" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Schedule Call</button>
    </form>
</div>
@endsection

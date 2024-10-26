@extends('layout.app')

@section('content')
<div class="container">
    <h2>Call Schedules</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('callschedule.create') }}" class="btn btn-primary">Create New Schedule</a>
    
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedules as $schedule)
                <tr>
                    <td>{{ $schedule->scheduled_date }}</td>
                    <td>{{ $schedule->scheduled_time }}</td>
                    <td>
                        @if($schedule->status == 'live')
                            <button class="btn btn-danger blinking">LIVE</button>
                        @else
                            {{ ucfirst($schedule->status) }}
                        @endif
                    </td>
                    <td>
                        @if($schedule->status == 'scheduled')
                            <form action="{{ route('callschedule.live', $schedule->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to go live?')">
                                @csrf
                                <button type="submit" class="btn btn-warning">Make Live</button>
                            </form>
                        @else
                            <span class="text-muted">Currently Live</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
<style>
.blinking {
    animation: blinkingText 1.5s infinite;
}

@keyframes blinkingText {
    0% { color: #fff; }
    49% { color: #fff; }
    50% { color: red; }
    99% { color: red; }
    100% { color: #fff; }
}
</style>

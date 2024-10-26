<?php

namespace App\Http\Controllers;

use App\Models\CallSchedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminCallScheduleController extends Controller
{
    public function index()
    {
        $schedules = CallSchedule::all();
        return view('admin.callschedule.index', compact('schedules'));
    }

    public function create()
    {
        return view('admin.callschedule.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'scheduled_date' => 'required|date',
            'scheduled_time' => 'required|date_format:H:i',
        ]);

        CallSchedule::create([
            'scheduled_date' => $request->scheduled_date,
            'scheduled_time' => $request->scheduled_time,
            'status' => 'scheduled',
        ]);

        return redirect()->route('callschedule.index')->with('success', 'Schedule created successfully.');
    }

    public function makeLive($id)
    {
        // Set all other schedules to 'scheduled'
        CallSchedule::where('status', 'live')->update(['status' => 'scheduled']);

        // Set selected schedule to 'live'
        $schedule = CallSchedule::findOrFail($id);
        $schedule->status = 'live';
        $schedule->save();

        return redirect()->route('callschedule.index')->with('success', 'Schedule is now live.');
    }

    public function getSchedules()
    {
        $schedules = CallSchedule::where('status', '!=', 'completed')->get();
        return response()->json($schedules);
    }
}


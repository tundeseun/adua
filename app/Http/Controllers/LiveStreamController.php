<?php
// app/Http/Controllers/LiveStreamController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LiveStream;
use Illuminate\Http\JsonResponse;

class LiveStreamController extends Controller
{
    // Display the form and the current live stream link
    public function showAdminInterface()
    {
        $liveStream = LiveStream::latest()->first();
        return view('admin.live-stream', compact('liveStream'));
    }

    // Update the live stream link
    // Update the live stream link
public function updateLiveStream(Request $request)
{
    $request->validate([
        'youtube_link' => 'required|url',
    ]);

    $liveStream = LiveStream::latest()->first();
    
    if ($liveStream) {
        $liveStream->update(['youtube_link' => $request->youtube_link]);
    } else {
        LiveStream::create(['youtube_link' => $request->youtube_link]);
    }

    return redirect()->back()->with('success', 'Live stream link updated successfully.');
}

    // API to get the latest live stream link
    public function getLiveStreamLink(): JsonResponse
    {
        $liveStream = LiveStream::latest()->first();
        if ($liveStream) {
            return response()->json([
                'success' => true,
                'youtube_link' => $liveStream->youtube_link,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No live stream link available.',
        ]);
    }
}

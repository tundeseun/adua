<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimony;

class TestimonyController extends Controller
{
    // Send voice testimony
    public function sendVoiceTestimony(Request $request)
    {
        $request->validate([
            'voice_note' => 'nullable|mimetypes:audio/*', // Allow any audio file type or null
            'user_id' => 'required|integer',
        ]);

     // Ensure the directory exists for uploads
    if (!file_exists(public_path('uploads/voices'))) {
        mkdir(public_path('uploads/voices'), 0755, true); // Create directory if it doesn't exist
    }

    // Handle the voice_note file if it exists
    if ($request->hasFile('voice_note')) {
        // Generate a unique file name
        $fileName = time() . '.' . $request->voice_note->getClientOriginalExtension(); 
        // Move the uploaded file to the 'uploads/voices' directory
        $request->voice_note->move(public_path('uploads/voices'), $fileName);

        // Set the file path for saving to the database
        $filePath = 'uploads/voices/' . $fileName;
    } else {
        // If no file is uploaded, set file_path to null
        $filePath = null;
    }

        $testimony = Testimony::create([
            'user_id' => $request->user_id,  // Get user_id from the request
            'testimony_type' => 'voice',
            'file_path' => $filePath, 
        ]);

        return response()->json(['message' => 'Voice testimony sent successfully', 'testimony' => $testimony], 201);
    }

    // Send text testimony
    public function sendTextTestimony(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'user_id' => 'required|integer', // Ensure user_id is supplied and valid
        ]);

        $testimony = Testimony::create([
            'user_id' => $request->user_id,  // Get user_id from the request
            'testimony_type' => 'text',
            'text' => $request->text,
        ]);

        return response()->json(['message' => 'Text testimony sent successfully', 'testimony' => $testimony], 201);
    }
}

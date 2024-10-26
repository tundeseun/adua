<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Register a new user
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'user', // Default value
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }


     // Register a new user
     public function registeradmin(Request $request)
{
    // Validate request data
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6',
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Create new admin user
    try {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'admin',
        ]);

        // Return success message
        return redirect()->back()->with('success', 'User registered successfully');
    } catch (\Exception $e) {
        // Return error message in case of failure
        return redirect()->back()->with('error', 'Error occurred while registering user');
    }
}


// Login
public function adminlogin(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return redirect()->back()->with('error', 'Invalid credentials');
        // return response()->json(['error' => 'Invalid credentials'], 401);
    }

    return redirect()->route('admin.dashboard')->with('success', 'Login successful');
}



    // Login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json(['message' => 'Login successful', 'user' => $user], 200);
    }

    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);
    $user->update([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'user_type' => $request->input('user_type'),
    ]);
    return response()->json(['success' => 'User updated successfully']);
}

public function destroy($id)
{
    User::destroy($id);
    return response()->json(['success' => 'User deleted successfully']);
}
}

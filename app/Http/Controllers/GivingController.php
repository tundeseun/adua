<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GivingController extends Controller
{
    public function initiatePayment(Request $request)
{
    // Validate request data
    $validator = Validator::make($request->all(), [
        'user_id' => 'required|exists:users,id',
        'amount' => 'required|numeric|min:1',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    // Fetch user data
    $user = User::find($request->user_id);

    // Convert amount to kobo (Paystack expects amount in kobo)
    $amountInKobo = $request->amount * 100;

    // Prepare data for Paystack API
    $postData = [
        'amount' => $amountInKobo,
        'email' => $user->email,
        'metadata' => [
            'user_id' => $user->id,
            'name' => $user->name,
        ],
        'callback_url' => url('/subscription/callback') // Full URL for the callback
    ];

    // Initialize cURL for Paystack API
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.paystack.co/transaction/initialize");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData)); // Use json_encode
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer sk_test_8f6ea4c8006d0174e71b8fdc38076af85a678ac5",
        "Content-Type: application/json",
    ]);
// Disable SSL verification (only for local testing)
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // Execute and capture response
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Check for cURL error
    if (curl_errno($ch)) {
        Log::error('cURL Error', ['error' => curl_error($ch)]);
        return response()->json([
            'status' => 'error',
            'message' => 'Unable to initiate payment. Check logs for details.'
        ], 500);
    }

    // Decode the response
    $responseData = json_decode($response);

    // Check if response is successful
    if ($httpcode === 200 && $responseData->status) {
        // Save initial payment record
        Payment::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'status' => 'pending',
            'transaction_reference' => $responseData->data->reference,
        ]);

        curl_close($ch);

        // Return authorization URL for redirection
        return response()->json([
            'status' => 'success',
            'authorization_url' => $responseData->data->authorization_url,
        ]);
    } else {
        // Log error for debugging
        Log::error('Paystack API Error', [
            'http_code' => $httpcode,
            'response' => $response
        ]);

        curl_close($ch);
        return response()->json([
            'status' => 'error',
            'message' => 'Unable to initiate payment. Check logs for details.'
        ], 500);
    }
}

    // Callback function
    public function handleCallback(Request $request)
    {
        // Verify transaction reference
        $reference = $request->input('reference');
        $url = "https://api.paystack.co/transaction/verify/" . urlencode($reference);

        // Initialize cURL for verification
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer sk_test_8f6ea4c8006d0174e71b8fdc38076af85a678ac5",
            "Cache-Control: no-cache"
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        // Execute and capture response
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpcode === 200) {
            $responseData = json_decode($response);

            // Find payment record by reference
            $payment = Payment::where('transaction_reference', $reference)->first();
            if (!$payment) {
                return response()->json(['status' => 'error', 'message' => 'Payment record not found'], 404);
            }

            // Update payment status based on verification response
            if ($responseData->data->status === 'success') {
                $payment->status = 'success';
            } else {
                $payment->status = 'failed';
            }
            $payment->save();

            return response()->json(['status' => 'success', 'message' => 'Payment verified successfully']);
        } else {
            Log::error('Paystack Verification API Error', [
                'http_code' => $httpcode,
                'response' => $response
            ]);
            return response()->json(['status' => 'error', 'message' => 'Payment verification failed'], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Payment extends Controller
{
    public function list(Request $request)
    {
        $client = \App\Models\Client::where('user_id', $request->user()->id)->first();
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $payments = \App\Models\Payment::with('policy', 'status', 'policy.client')->whereHas('policy', function ($query) use ($client) {
            $query->where('client_id', $client->id);
        })->get();

        return response()->json(['payments' => $payments], 200);
    }
}

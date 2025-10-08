<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Policy extends Controller
{
    public function list(Request $request)
    {
        $client = \App\Models\Client::where('user_id', $request->user()->id)->first();
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $search = $request->input('search');
        $type = $request->input('type');
        $status = $request->input('status');
        $query = \App\Models\Policies::with('status', 'client', 'payments', 'claims')->where('client_id', $client->id);

        $totalPolicies = $query->count();

        if ($search) {
            $query->where('policy_number', 'like', "%{$search}%");
        }

        if ($type && $type !== '-') {
            $query->where('type', $type);
        }

        if ($status && $status !== '-') {
            $query->where('status', $status);
        }

        $policies = $query->get();

        foreach ($policies as $policy) {
            if($policy->end_date < date('Y-m-d') && $policy->status != 3){
                $policy->status = 2;
                $policy->save();
            }
        }

        return response()->json(['policies' => $policies, 'total' => $totalPolicies], 200);
    }

    public function create(Request $request)
    {
        $client = \App\Models\Client::where('user_id', $request->user()->id)->first();
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $validatedData = $request->validate([
            'policy_number' => 'required|string|max:50|unique:policies',
            'type' => 'required|string|max:50',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $policy = \App\Models\Policies::create([
            'client_id' => $client->id,
            'policy_number' => $validatedData['policy_number'],
            'type' => $validatedData['type'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'status' => 2,
        ]);

        return response()->json(['message' => 'Policy created successfully', 'policy' => $policy], 201);
    }

    public function delete(Request $request)
    {
        $client = \App\Models\Client::where('user_id', $request->user()->id)->first();
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $validatedData = $request->validate([
            'policy_id' => 'required|integer|exists:policies,id',
        ]);

        $policy = \App\Models\Policies::where('id', $validatedData['policy_id'])->where('client_id', $client->id)->first();
        if (!$policy) {
            return response()->json(['message' => 'Policy not found'], 404);
        }

        if($policy->status == 2 || $policy->status == 1){
            $policy->status = 3;
            $policy->save();
            return response()->json(['message' => 'Policy is now cancelled'], 200);
        }

        $policy->delete();

        return response()->json(['message' => 'Policy deleted successfully'], 200);
    }

    public function payments(Request $request)
    {
        $client = \App\Models\Client::where('user_id', $request->user()->id)->first();
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $validatedData = $request->validate([
            'policy_id' => 'required|integer|exists:policies,id',
            'ammout' => 'required|numeric|min:0',
            'until' => 'nullable',
        ]);

        $policy = \App\Models\Policies::where('id', $validatedData['policy_id'])->where('client_id', $client->id)->first();
        if (!$policy) {
            return response()->json(['message' => 'Policy not found'], 404);
        }

        $payment = \App\Models\Payment::create([
            'policy_id' => $policy->id,
            'amount' => $validatedData['ammout'],
            'payment_date' => date('Y-m-d'),
        ]);

        $policy->status = 1;
        if (isset($validatedData['until'])) {
            $policy->end_date = $validatedData['until'];
        }
        $policy->save();

        return response()->json(['message' => 'Payment recorded successfully', 'payment' => $payment], 201);
    }

    public function restore(Request $request)
    {
        $client = \App\Models\Client::where('user_id', $request->user()->id)->first();
        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        $validatedData = $request->validate([
            'policy_id' => 'required|integer|exists:policies,id',
        ]);

        $policy = \App\Models\Policies::where('id', $validatedData['policy_id'])->where('client_id', $client->id)->first();
        if (!$policy) {
            return response()->json(['message' => 'Policy not found'], 404);
        }

        if($policy->status != 3){
            return response()->json(['message' => 'Only cancelled policies can be restored'], 400);
        }

        if($policy->end_date < date('Y-m-d')){
            $policy->status = 2;
        }else{
            $policy->status = 1;
        }
        
        $policy->save();

        return response()->json(['message' => 'Policy restored successfully', 'policy' => $policy], 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Admin extends Controller
{
    public function adminData(Request $request)
    {
        $user = $request->user();
        if ($user->role_id != 1) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $totalUsers = \App\Models\User::count();
        $totalPolicies = \App\Models\Policies::count();
        $totalPayments = \App\Models\Payment::count();

        $activePolicies = \App\Models\Policies::where('status', 1)->count();

        $last5Users = \App\Models\User::with('role', 'client')->orderBy('created_at', 'desc')->take(5)->get();

        return response()->json([
            'total_users' => $totalUsers,
            'total_policies' => $totalPolicies,
            'total_payments' => $totalPayments,
            'active_policies' => $activePolicies,
            'last_5_users' => $last5Users,
        ]);
    }
}

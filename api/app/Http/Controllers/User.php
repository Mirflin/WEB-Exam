<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class User extends Controller
{
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'personal_code' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'level'=> 'nullable|integer|in:1,2',
        ]);

        $user = \App\Models\User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role_id' => $validatedData['level'] ?? 2,
            'active' => true,
        ]);

        $client = new \App\Models\Client([
            'user_id' => $user->id,
            'personal_code' => $validatedData['personal_code'] ?? null,
            'address' => $validatedData['address'] ?? null,
            'phone' => $validatedData['phone'] ?? null,
        ]);
        $client->save();

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    public function update(Request $request)
    {
        $user_id = $request->input('id');
        $user = \App\Models\User::find($user_id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $image_base64 = $request->input('avatar');
        if ($image_base64) {
            $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image_base64));
            $image_name = 'avatar_' . time() . '.png';
            $image_path = public_path('storage/avatars/' . $image_name);
            file_put_contents($image_path, $image_data);
            $user->avatar = $image_name;
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'sometimes',
            'personal_code' => 'sometimes|nullable|string|max:20',
            'address' => 'sometimes|nullable|string|max:255',
            'phone' => 'sometimes|nullable|string|max:20',
            'level'=> 'sometimes|nullable|integer|in:1,2',
        ]);

        if (isset($validatedData['name'])) {
            $user->name = $validatedData['name'];
        }
        if (isset($validatedData['email'])) {
            $user->email = $validatedData['email'];
        }
        if (isset($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }
        if (isset($validatedData['level'])) {
            $user->role_id = $validatedData['level'];
        }
        $user->save();

        $client = \App\Models\Client::where('user_id', $user->id)->first();
        if ($client) {
            if (array_key_exists('personal_code', $validatedData)) {
                $client->personal_code = $validatedData['personal_code'];
            }
            if (array_key_exists('address', $validatedData)) {
                $client->address = $validatedData['address'];
            }
            if (array_key_exists('phone', $validatedData)) {
                $client->phone = $validatedData['phone'];
            }
            $client->save();
        }

        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }

    public function allUsers(Request $request)
    {
        $users = \App\Models\User::with('role', 'client')->get();
        $totalPolicies = \App\Models\Policies::count();
        return response()->json(['users' => $users, 'totalPolicies' => $totalPolicies], 200);
    }

    public function delete(Request $request)
    {
        $user_id = $request->input('id');
        $user = \App\Models\User::find($user_id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->active = false;
        $user->save();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    public function restore(Request $request)
    {
        $user_id = $request->input('id');
        $user = \App\Models\User::find($user_id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->active = true;
        $user->save();

        return response()->json(['message' => 'User restored successfully'], 200);
    }

}

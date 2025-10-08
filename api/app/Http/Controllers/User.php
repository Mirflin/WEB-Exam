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
        ]);

        $user = \App\Models\User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
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
        $user = $request->user();

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|string|min:8',
            'personal_code' => 'sometimes|nullable|string|max:20',
            'address' => 'sometimes|nullable|string|max:255',
            'phone' => 'sometimes|nullable|string|max:20',
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
}

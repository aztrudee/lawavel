<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email,' . $user->id,
            'gender'          => 'nullable|in:Male,Female,Other',
            'address'         => 'nullable|string|max:500',
            'password'        => 'nullable|min:6|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $data = $request->only('name', 'email', 'gender', 'address');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('profile_picture')) {
            $file     = $request->file('profile_picture');
            $mime     = $file->getMimeType();
            $binary   = file_get_contents($file->getRealPath());
            $base64   = base64_encode($binary);

            $data['profile_picture_base64'] = 'data:' . $mime . ';base64,' . $base64;
        }

        $user->update($data);
        return redirect()->route('profile.show')->with('toast_success', 'Profile updated successfully!');
    }
}

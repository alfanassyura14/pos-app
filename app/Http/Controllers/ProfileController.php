<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'u_name' => ['required', 'string', 'max:255'],
            'u_email' => ['required', 'string', 'email', 'max:255', 'unique:users,u_email,' . $user->id . ',id'],
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        // Update name and email
        $user->u_name = $request->u_name;
        $user->u_email = $request->u_email;

        // Update password if provided
        if ($request->filled('current_password') && $request->filled('new_password')) {
            // Verify current password
            if (!Hash::check($request->current_password, $user->u_password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
            }

            $user->u_password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('profile_success', 'Profile updated successfully!');
    }
}

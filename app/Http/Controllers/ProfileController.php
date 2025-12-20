<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show the user profile edit form
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'email.unique' => 'This email is already taken.',
            'current_password.required_with' => 'Current password is required to change your password.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        // Check current password if password change is requested
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'The provided password does not match our records.']);
            }
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
            unset($validated['current_password']);
        }

        // Update user
        $user->update($validated);

        return redirect()->route('profile.edit')
            ->with('success', 'Profile updated successfully! ✅');
    }

    /**
     * Show user profile (view only)
     */
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }
}

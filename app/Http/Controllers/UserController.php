<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $query = User::query();
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('u_name', 'like', "%{$search}%")
                  ->orWhere('u_email', 'like', "%{$search}%");
            });
        }
        
        $users = $query->orderBy('created_at', 'desc')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Search users via AJAX
     */
    public function search(Request $request)
    {
        $query = User::query();
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('u_name', 'like', "%{$search}%")
                  ->orWhere('u_email', 'like', "%{$search}%");
            });
        }
        
        $users = $query->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }

    /**
     * Store a new user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'u_name' => 'required|string|max:255',
            'u_email' => 'required|email|unique:users,u_email',
            'u_password' => 'required|string',
            'role' => 'required|in:admin,sub_admin,user',
            'menu_access' => 'nullable|array',
        ]);

        $validated['u_password'] = Hash::make($validated['u_password']);

        $user = User::create($validated);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    /**
     * Update user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'u_name' => 'required|string|max:255',
            'u_email' => ['required', 'email', Rule::unique('users', 'u_email')->ignore($user->id)],
            'u_password' => 'nullable|string',
            'role' => 'required|in:admin,sub_admin,user',
            'menu_access' => 'nullable|array',
        ]);

        // Only update password if provided
        if (!empty($validated['u_password'])) {
            $validated['u_password'] = Hash::make($validated['u_password']);
        } else {
            unset($validated['u_password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    /**
     * Update menu access via AJAX
     */
    public function updateMenuAccess(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'menu_access' => 'required|array',
        ]);

        $user->update([
            'menu_access' => $validated['menu_access']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Menu access updated successfully',
        ]);
    }

    /**
     * Delete user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'You cannot delete your own account');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}

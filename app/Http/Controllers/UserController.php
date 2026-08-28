<?php

namespace App\Http\Controllers;

use App\Mail\UserCreatedWelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role') && in_array($request->input('role'), ['admin', 'user'])) {
            $query->where('role', $request->input('role'));
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'in:admin,user'],
            'password' => [
                'required',
                'confirmed',
                Password::defaults(),
            ],
        ], [
            'password.min' => 'The password must be at least 10 characters.',
            'password.mixed' => 'The password must contain both uppercase and lowercase letters.',
            'password.symbols' => 'The password must contain at least one special character.',
            'password.numbers' => 'The password must contain at least one number.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'email_verified_at' => ($request->role === 'admin' ? now() : null),
        ]);

        // Send welcome email with credentials
        try {
            Mail::to($user->email)->send(
                new UserCreatedWelcomeMail($user, $request->password)
            );
        } catch (\Throwable $e) {
            logger()->warning('Google SMTP UserCreatedWelcomeMail error: ' . $e->getMessage());
        }

        return redirect()->route('users.index')
            ->with('success', "User '{$request->name}' created successfully and a welcome email has been sent.");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:admin,user'],
            'password' => [
                'nullable',
                'confirmed',
                Password::defaults(),
            ],
        ], [
            'password.min' => 'The password must be at least 10 characters.',
            'password.mixed' => 'The password must contain both uppercase and lowercase letters.',
            'password.symbols' => 'The password must contain at least one special character.',
            'password.numbers' => 'The password must contain at least one number.',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('users.index')
            ->with('success', "User '{$user->name}' updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        if ($user->isAdmin() && User::where('role', 'admin')->count() <= 1) {
            return redirect()->route('users.index')
                ->with('error', 'Cannot delete the last remaining administrator.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', "User '{$userName}' has been deleted successfully.");
    }
}

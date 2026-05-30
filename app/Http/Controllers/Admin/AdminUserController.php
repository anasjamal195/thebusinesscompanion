<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::withCount('calls')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->loadCount('calls');
        $user->load(['calls' => fn($q) => $q->latest()->take(10)]);
        return view('admin.users.show', compact('user'));
    }
}

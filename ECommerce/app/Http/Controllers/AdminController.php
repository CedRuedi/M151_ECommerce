<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('admin.users', compact('users', 'roles'));
    }

    public function assignRole(Request $request, User $user) {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->roles()->sync([$request->role_id]); // Rimuove i ruoli precedenti e assegna il nuovo

        return redirect()->back()->with('success', 'Ruolo aggiornato con successo!');
    }
}

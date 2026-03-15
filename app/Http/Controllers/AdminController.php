<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Siguraduhin na ang Model mo ay 'User' o 'Account'
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        // Kinukuha lahat ng data para hindi mag-error ang table
        $accounts = User::all(); 
        return view('manage_accounts', compact('accounts'));
    }

    public function store(Request $request)
    {
        // Logic para sa pag-create ng account
        User::create([
            'user' => $request->user,
            'password' => Hash::make($request->pass),
            'role' => $request->role,
        ]);
        return back()->with('success', 'Account Created!');
    }

    public function destroy($id)
    {
        // Hanapin ang user gamit ang ID at burahin
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Account deleted successfully!');
    }
}

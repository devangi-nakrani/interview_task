<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    public function invite(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required'
        ]);

        // 2. SuperAdmin : Create New Company + Admin
        if ($user->role == 'SuperAdmin' && $request->role == 'Admin') {
            $company = Company::create(['name' => $request->company_name ?? 'New Company']);
            
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('password123'),
                'role' => 'Admin',
                'company_id' => $company->id
            ]);

            return back()->with('success', 'Admin invited to new company!');
        }

        // 3. Admin : Invite to own company
        if ($user->role == 'Admin' && in_array($request->role, ['Admin', 'Member'])) {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('password123'),
                'role' => $request->role,
                'company_id' => $user->company_id
            ]);

            return back()->with('success', 'User invited to your company!');
        }

        return back()->with('error', 'You cannot invite this role.');
    }
}


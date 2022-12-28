<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user(); // \App\Models\User
        
        return view('dashboard.profile.edit', [
            'user' => $user,
            'countries' => Countries::getNames('ar'),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'birthday' => 'nullable|date|before:now',
            'gender' => 'nullable|in:male,female',
            'country' => 'string|size:2'
        ]);

        $user = $request->user();
        $user->profile->fill($validated)->save();

        return back()->with('success', 'Profile updated!');

    }
}

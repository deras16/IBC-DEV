<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class TempPasswordChangeController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('Auth/TempPasswordChange');
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::min(8), 'confirmed'],
        ]);

        $user = auth()->user();
        $user->password = Hash::make($request->password);
        //$user->must_change_password = false;
        $user->save();

        return redirect()->route('dashboard')->with([
            'type' => 'success',
            'message' => 'Temporal password was change successfully.',
        ]);
    }
}

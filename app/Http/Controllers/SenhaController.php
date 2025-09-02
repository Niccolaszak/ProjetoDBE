<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class SenhaController extends Controller
{
    public function show()
    {
        return view('auth.senha-redefinir');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->forcar_redefinir_senha = false;
        $user->save();

        return redirect()->route('dashboard');
    }
}

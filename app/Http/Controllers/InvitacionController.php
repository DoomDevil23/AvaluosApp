<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitacion;
use Illuminate\Support\Str;

class InvitacionController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'dias' => 'required|integer|min:1',
            'idRole' => 'required',
        ]);

        $token = Str::random(40);

        Invitacion::create([
            'token' => $token,
            'idRole' => $request->idRole,
            'is_used' => false,
            'expired_at' => now()->addDays((int) $request->dias),
        ]);

        $link = route('register', ['token' => $token]);
        session(['invitation_link' => $link]);

        // Puedes enviar este enlace por correo o simplemente retornarlo
        return back()->with('success', "Invitación creada: $link");
    }
}

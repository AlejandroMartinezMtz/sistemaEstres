<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuarios;

class AuthController extends Controller
{

    // Función para cerrar sesión activa
    public function logout(Request $request)
    {
        Auth::logout(); // Cerrar sesión

        $request->session()->invalidate(); // Invalidar la sesión
        $request->session()->regenerateToken(); // Regenerar el token de sesión

        return redirect('/'); // Redirigir a la página de inicio
    }
}

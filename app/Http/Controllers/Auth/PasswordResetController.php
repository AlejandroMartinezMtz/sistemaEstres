<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuarios;  
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Str;

class PasswordResetController extends Controller
{
    // 1. Mostrar el formulario para ingresar el correo electrónico
    public function showEmailForm() {
        return view('email');
    }

    // 2. Enviar el código de verificación al correo
    public function sendVerificationCode(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:usuario,correoInstitucional',
        ]);

        $usuario = Usuarios::where('correoInstitucional', $request->email)->first();

        // Generar un código de verificación
        $codigo = Str::random(6);
        $usuario->codigoVerificacion = $codigo;
        $usuario->save();

        // Enviar el código por correo
        Mail::to($usuario->correoInstitucional)->send(new \App\Mail\VerificationCodeMail($codigo));

        return redirect()->route('password.verify')->with('email', $usuario->correoInstitucional);
    }

    // 3. Mostrar el formulario para ingresar el código de verificación
    public function showVerificationForm() {
        session()->flash('success', '¡Listo! Revisa tu correo o en la bandeja de spam, se ha enviado un código de verificación.');
        return view('verify');
    }

    // 4. Verificar el código ingresado
    public function verifyCode(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:usuario,correoInstitucional',
            'code' => 'required',
        ]);

        $usuario = Usuarios::where('correoInstitucional', $request->email)->first();

        if ($usuario->codigoVerificacion === $request->code) {
            return redirect()->route('password.reset_form')->with('email', $usuario->correoInstitucional);
        }

        return back()->withErrors(['code' => 'El código de verificación no es correcto.']);
    }

    // 5. Mostrar el formulario para restablecer la contraseña
    public function showResetForm() {
        return view('reset');
    }

    // 6. Restablecer la contraseña
    public function resetPassword(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:usuario,correoInstitucional',
            'password' => 'required|confirmed|min:8',
        ]);

        $usuario = Usuarios::where('correoInstitucional', $request->email)->first();
        $usuario->contrasenia = Hash::make($request->password);
        $usuario->codigoVerificacion = null;
        $usuario->save();

        return redirect()->route('login.view')->with('status', 'Contraseña restablecida con éxito.');
    }
}

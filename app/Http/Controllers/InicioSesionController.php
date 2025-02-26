<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios; 
use App\Models\TipoUsuario; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class InicioSesionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }



    // Esta función procesa el formulario de inicio de sesión, se recibe como entrada el correo y la contraseña
    public function login(Request $request)
    {
          // Validar los datos del formulario
    $request->validate([
        'correo' => 'required|email',
        'contrasenia' => 'required',
    ]);

    // Obtener los datos del formulario
    $correo = $request->input('correo');
    $contrasenia = $request->input('contrasenia');

    // Buscar al usuario en la base de datos usando Eloquent
    $usuario = Usuarios::with('tipoUsuario')->where('correoInstitucional', $correo)->first();

    // Verificar si el usuario existe, la contraseña es correcta y el usuario está activo
    if ($usuario) {
        if ($usuario->estadoActivo == 0) {
            return redirect('/')->withErrors(['Tu cuenta está inactiva. Comunícate con el administrador para más información.']);
        }

            if (Hash::check($contrasenia, $usuario->contrasenia)) {
                Auth::login($usuario);
                $request->session()->regenerate();
                //Rederige al usuario a su vista establecida
                switch ($usuario->tipoUsuario->tipo)  {
                    case 'Administrador':
                        return redirect()->route('admin.dashboard');
                    case 'Profesor':
                        return redirect()->route('profesor.dashboard');
                    case 'Alumno':
                        return redirect()->route('alumno.inicio');
                    default:
                        return redirect('/')->withErrors(['Tipo de usuario desconocido.']);
                }
            }
        }

        return redirect('/')->withErrors(['Correo o contraseña incorrectos, intente de nuevo.']);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

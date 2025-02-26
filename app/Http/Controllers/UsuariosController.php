<?php

namespace App\Http\Controllers;
use App\Models\Usuarios;  
use Illuminate\Http\Request;
use App\Models\ProgramasEducativos;
use App\Models\TipoUsuario;
use App\Models\AlumnosCreados; 
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Función para mostrar el listado de usuarios al administrador
    public function index(Request $request)
    {
        $search = $request->input('search');

        $usuarios = Usuarios::when($search, function ($query, $search) {
        return $query->where('nombre', 'LIKE', "%{$search}%")
            ->orWhere('apellidoP', 'LIKE', "%{$search}%")
            ->orWhere('apellidoM', 'LIKE', "%{$search}%")
            ->orWhere('sexo', 'LIKE', "%{$search}%")
            ->orWhere('correoInstitucional', 'LIKE', "%{$search}%")
            ->orWhere('matricula', 'LIKE', "%{$search}%");
        })->get();

        return view('usuarios.index', compact('usuarios'));

    }

    //Función que meustra el dashboard del usuario administrador
    public function adminDashboard()
    {
         // Ejemplo de obtención de datos
         $genderData = [
            'Hombres' => Usuarios::where('sexo', 'Hombre')->count(),
            'Mujeres' => Usuarios::where('sexo', 'Mujer')->count()
        ];

        $surveyData = [
            'Bajo' => NivelesSatisfaccion::where('nivel', 'Bajo')->count(),
            'Bajo-Medio' => NivelesSatisfaccion::where('nivel', 'Bajo-Medio')->count(),
            'Medio' => NivelesSatisfaccion::where('nivel', 'Medio')->count(),
            'Medio-Alto' => NivelesSatisfaccion::where('nivel', 'Medio-Alto')->count(),
            'Alto' => NivelesSatisfaccion::where('nivel', 'Alto')->count()
        ];


        $forumData = [
            'Publicaciones' => Foro::count(),
            'Comentarios' => ComentariosForo::count(),
        ];

        $stressData = [
            'Sin estrés' => EvaluacionEstres::where('nivelEstres', 'Sin estrés')->count(),
            'Estrés leve' => EvaluacionEstres::where('nivelEstres', 'Estrés leve')->count(),
            'Estrés medio' => EvaluacionEstres::where('nivelEstres', 'Estrés medio')->count(),
            'Estrés alto' => EvaluacionEstres::where('nivelEstres', 'Estrés alto')->count()
        ];


        return view('admin_dashboard', compact('genderData', 'surveyData', 'forumData', 'stressData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Función para crear un usuario por parte del admin
    public function create()
    {
          $programas = ProgramasEducativos::where('estado', 1)->get(); 
          $tipos = TipoUsuario::all();
          return view('usuarios.create', compact('programas', 'tipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     //Función para crear un usuario nuevo
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidoP' => 'required|string|max:255',
            'apellidoM' => 'required|string|max:255',
            'fechaNac' => 'required|string|max:255',
            'sexo' => 'required|string|max:255',
            'estadoActivo' => 'required|string|max:255',
            'correoPersonal' => 'required|email|max:255|unique:usuario,correoPersonal',
            'correoInstitucional' => 'required|email|max:255|unique:usuario,correoInstitucional',
            'matricula' => 'required|string|max:255|unique:usuario,matricula',
            'tipoUsuario' => 'required|string|max:255',
            'programaEducativo' => 'required|exists:programaEducativo,idProgramaEducativo',
        ]);


        // Generar una contraseña aleatoria
        $contraseniaGenerada = Str::random(8); 

        $usuario = new Usuarios;
        $usuario->nombre = $request->nombre;
        $usuario->apellidoP = $request->apellidoP;
        $usuario->apellidoM = $request->apellidoM;
        $usuario->fechaNac = $request->fechaNac;
        $usuario->sexo = $request->sexo;
        $usuario->estadoActivo = $request->estadoActivo;
        $usuario->correoPersonal = $request->correoPersonal;
        $usuario->correoInstitucional = $request->correoInstitucional;
        $usuario->contrasenia = $contraseniaGenerada;
        $usuario->matricula = $request->matricula;
        $usuario->fk_tipo_usuario = $request->tipoUsuario;
        $usuario->fk_programaEducativo = $request->programaEducativo;
        $usuario->save();


        $alumnoCreado = new AlumnosCreados;
        $alumnoCreado->fk_idAlumnoC = $usuario->idUsuario;
        $alumnoCreado->fk_idProfesorCreador = auth()->user()->idUsuario;
        $alumnoCreado->save();

        // Enviar correo con las credenciales
        Mail::send('emails.credentials', [
            'nombre' => $usuario->nombre,
            'correoInstitucional' => $usuario->correoInstitucional,
            'contrasenia' => $contraseniaGenerada
        ], function($message) use ($usuario) {
            $message->to($usuario->correoPersonal);
            $message->subject('Tus credenciales de acceso');
        });

   
        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');

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

     //Función para mostrar la vista editar usuario
    public function edit($id)
    {
        $usuario = Usuarios::findOrFail($id);
        $programas = ProgramasEducativos::where('estado', 1)->get();
        $tipos = TipoUsuario::all();
   
        return view('usuarios.edit', compact('usuario', 'programas', 'tipos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //Función para actualizar los datos editados de un usuario
    public function update(Request $request, $id)
    {
         // Validar los datos recibidos
        $request->validate([
        'nombre' => 'required|string|max:255',
        'apellidoP' => 'required|string|max:255',
        'apellidoM' => 'required|string|max:255',
        'fechaNac' => 'required|string|max:255',
        'sexo' => 'required|string|max:255',
        'estadoActivo' => 'required|string|max:255',
        'correoPersonal' => 'required|email|max:255',
        'correoInstitucional' => 'required|email|max:255',
        'matricula' => 'required|string|max:255',
        'tipoUsuario' => 'required|string|max:255',
        'programaEducativo' => 'required|exists:programaEducativo,idProgramaEducativo',
        ]);

        // Obtener el usuario 
        $usuario = Usuarios::findOrFail($id);
        $usuario->nombre = $request->nombre;
        $usuario->apellidoP = $request->apellidoP;
        $usuario->apellidoM = $request->apellidoM;
        $usuario->fechaNac = $request->fechaNac;
        $usuario->sexo = $request->sexo;
        $usuario->estadoActivo = $request->estadoActivo;
        $usuario->correoPersonal = $request->correoPersonal;
        $usuario->correoInstitucional = $request->correoInstitucional;
        $usuario->matricula = $request->matricula;
        $usuario->fk_tipo_usuario = $request->tipoUsuario;
        $usuario->fk_programaEducativo = $request->programaEducativo;
        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //Funcion par eliminar(desactivar) un usuario mediante su id
    public function destroy($id)
    {
        $usuario = Usuarios::findOrFail($id);

        // Cambia el estadoActivo a 0 (inactivo)
        $usuario->estadoActivo = 0;
        $usuario->save();
        
        return redirect()->route('usuarios.index')->with('success', 'Usuario desactivado correctamente.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AlumnosCreados; 
use App\Models\Usuarios;
use App\Models\ProgramasEducativos; 
use App\Models\TipoUsuario;
use App\Models\Ejercicios;
use App\Models\Pasatiempos;   
use App\Models\AsignacionesMaterial;
use App\Models\AsignacionesEjercicios;
use App\Models\AsignacionesPasatiempos;
use App\Models\Encuestas;
use App\Models\EncuestasAlumnos;
use App\Models\EvaluacionEstres;
use App\Models\Foro;
use App\Models\ComentariosForo;
use App\Models\NivelesSatisfaccion;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class ProfesorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Esta función muestra la vista de gestión de usuarios
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        $profesor = auth()->user();

        $alumnos = Usuarios::whereHas('alumnosCreadosProfesor', function ($query) use ($profesor) {
            $query->where('fk_idProfesorCreador', $profesor->idUsuario);
        })
        ->when($search, function ($query, $search) {
            return $query->where('nombre', 'LIKE', "%{$search}%")
                     ->orWhere('apellidoP', 'LIKE', "%{$search}%")
                     ->orWhere('apellidoM', 'LIKE', "%{$search}%")
                     ->orWhere('sexo', 'LIKE', "%{$search}%")
                     ->orWhere('correoInstitucional', 'LIKE', "%{$search}%")
                     ->orWhere('matricula', 'LIKE', "%{$search}%");
        })
        ->get();

        return view('usuariosProfesor.index', compact('alumnos'));
    }



    //Esta función muestra el dashboard del profesor
    public function profesorDashboard()
    {

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


        return view('dashboardProfesor', compact('genderData', 'surveyData', 'forumData', 'stressData'));
    }


    //Esta función muestra la vista del modulo asiganación de recomendaciones
    public function envioRecomendacion(Request $request){
        $search = $request->input('search');

        $profesor = auth()->user();

        // Filtra los alumnos creados por este profesor, que tengan estrés alto y estén activos
        $alumnos = Usuarios::whereHas('alumnosCreadosProfesor', function ($query) use ($profesor) {
            $query->where('fk_idProfesorCreador', $profesor->idUsuario);
        })
        ->whereHas('evaluacion', function ($query) {
            // Filtra los alumnos con estrés alto
            $query->whereIn('nivelEstres', ['Estrés alto', 'Estrés medio']);
        })
        ->where('estadoActivo', 1)
        ->when($search, function ($query, $search) {
        return $query->where('nombre', 'LIKE', "%{$search}%")
                     ->orWhere('apellidoP', 'LIKE', "%{$search}%")
                     ->orWhere('apellidoM', 'LIKE', "%{$search}%")
                     ->orWhere('sexo', 'LIKE', "%{$search}%")
                     ->orWhere('correoInstitucional', 'LIKE', "%{$search}%")
                     ->orWhere('matricula', 'LIKE', "%{$search}%");
        })
        ->with(['evaluacion' => function ($query) {
            $query->orderBy('fechaRegistro', 'desc');
        }, 'ejerciciosSeleccionados.ejercicio', 'pasatiemposSeleccionados.pasatiempo']) // Relación con ejercicios y pasatiempos seleccionados
        ->get();

        $ejercicios = Ejercicios::all(); 
        $pasatiempos = Pasatiempos::all(); 

        // Retorna la vista con los resultados filtrados
        return view('material.index', compact('alumnos', 'ejercicios', 'pasatiempos'));
    }




    //Esta función muestra la vista para el modulo asiganción de encuesta personalizada
    public function envioEncuesta(Request $request){
        $search = $request->input('search');

        $profesor = auth()->user();

        // Filtra los alumnos creados por este profesor, que tengan estrés alto y estén activos
        $alumnos = Usuarios::whereHas('alumnosCreadosProfesor', function ($query) use ($profesor) {
            $query->where('fk_idProfesorCreador', $profesor->idUsuario);
        })
        ->whereHas('evaluacion', function ($query) {
            // Filtra los alumnos con estrés alto y medio
            $query->whereIn('nivelEstres', ['Estrés medio', 'Estrés alto']);
        })
        ->where('estadoActivo', 1)
        ->when($search, function ($query, $search) {
            return $query->where('nombre', 'LIKE', "%{$search}%")
                     ->orWhere('apellidoP', 'LIKE', "%{$search}%")
                     ->orWhere('apellidoM', 'LIKE', "%{$search}%")
                     ->orWhere('sexo', 'LIKE', "%{$search}%")
                     ->orWhere('correoInstitucional', 'LIKE', "%{$search}%")
                     ->orWhere('matricula', 'LIKE', "%{$search}%");
        })
        ->with(['evaluacion' => function ($query) {
            $query->orderBy('fechaRegistro', 'desc');
        }, 'ejerciciosSeleccionados.ejercicio', 'pasatiemposSeleccionados.pasatiempo']) // Relación con ejercicios y pasatiempos seleccionados
        ->get();

        $ejercicios = Ejercicios::all(); 
        $pasatiempos = Pasatiempos::all(); 
        $encuestas = Encuestas::all();

        // Retorna la vista con los resultados filtrados
        return view('encuestas.envio', compact('alumnos', 'encuestas','ejercicios', 'pasatiempos'));
    }


    //Función para asignar encuesta a los alumnos
    public function asignarEncuesta(Request $request){
        $idEncuesta = $request->input('id_encuesta');
        $alumnosSeleccionados = $request->input('alumnos', []);
        $profeId = Auth::user()->idUsuario;

        foreach ($alumnosSeleccionados as $idAlumno) {
            // Crear la asignación de la encuesta al alumno
            EncuestasAlumnos::create([
                'fk_idEncuestaE' => $idEncuesta,
                'fk_idAlumnoE' => $idAlumno,
                'fk_idProfeAsignacion' => $profeId,
                'fechaAsignacion' => now(),
            ]);

            $usuario = Usuarios::findOrFail($idAlumno);
            $encuesta = Encuestas::findOrFail($idEncuesta);

            // Enviar correo notificando la asignación de una encuesta
            Mail::send('emails.encuestas', [
                'nombre' => $usuario->nombre,
                'objetivo' => $encuesta->objetivo
            ], function($message) use ($usuario) {
                $message->to($usuario->correoInstitucional);
                $message->subject('Asignación de encuesta');
            });
        }

        return redirect()->back()->with('success', 'Encuesta asignada exitosamente.');
    }


    //Función que permite crear la asignación de material par alos alumnos
    public function asignarMaterial(Request $request){
        $alumnoId = $request->input('idUsuario_alumno');
        $profesorId = $request->input('idUsuario_profesor');
        $fechaRegistro = now();
    

        $asignacionMaterial = AsignacionesMaterial::create([
            'idUsuario_alumno' => $alumnoId,
            'idUsuario_profesor' => $profesorId,
            'fechaRegistro' => $fechaRegistro,
        ]);
    

        $ejerciciosAsignados = [];
        if ($request->has('ejercicios')) {
            foreach ($request->input('ejercicios') as $ejercicioId) {
                $ejercicio = Ejercicios::findOrFail($ejercicioId);
                $ejerciciosAsignados[] = $ejercicio->nombre;

                $existeAsignacionEjercicio = AsignacionesEjercicios::whereHas('material', function ($query) use ($alumnoId) {
                    $query->where('idUsuario_alumno', $alumnoId);
                })
                ->where('idEjercicio', $ejercicioId)
                ->exists();

                if (!$existeAsignacionEjercicio) {
                    AsignacionesEjercicios::create([
                        'idMaterial' => $asignacionMaterial->idMaterialA,
                        'idEjercicio' => $ejercicioId,
                    ]);
                }
            }
        }

        $pasatiemposAsignados = [];
        if ($request->has('pasatiempos')) {
            foreach ($request->input('pasatiempos') as $pasatiempoId) {
                $pasatiempo = Pasatiempos::findOrFail($pasatiempoId);
                $pasatiemposAsignados[] = $pasatiempo->nombre;

                $existeAsignacionPasatiempo = AsignacionesPasatiempos::whereHas('material', function ($query) use ($alumnoId) {
                    $query->where('idUsuario_alumno', $alumnoId);
                })
                ->where('idPasatiempo', $pasatiempoId)
                ->exists();

                if (!$existeAsignacionPasatiempo) {
                    AsignacionesPasatiempos::create([
                        'idMaterial' => $asignacionMaterial->idMaterialA,
                        'idPasatiempo' => $pasatiempoId,
                    ]);
                }
            }
        }

        // Obtener la información del usuario para enviar el correo
        $usuario = Usuarios::findOrFail($alumnoId);

        // Enviar el correo con las recomendaciones
        Mail::send('emails.recomendaciones', [
            'nombre' => $usuario->nombre,
            'ejercicios' => $ejerciciosAsignados,
            'pasatiempos' => $pasatiemposAsignados
        ], function($message) use ($usuario) {
            $message->to($usuario->correoInstitucional);
            $message->subject('Recomendaciones');
        });

        return redirect()->back()->with('success', 'Recursos asignados correctamente al alumno.');
    }







    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //Función para mostrar la vista de crear un usuario
    public function create()
    {
        // Obtener la lista de programas educativos
        $programas = ProgramasEducativos::where('estado', 1)->get();
        $tipoAlumno = TipoUsuario::where('tipo', 'Alumno')->first();

        // Retornar la vista de edición con los datos
        return view('usuariosProfesor.create', compact('programas'))
        ->with('tipoAlumno', $tipoAlumno->idTipo_usuario);
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
       // Validar los datos recibidos
         $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidoP' => 'required|string|max:255',
            'apellidoM' => 'required|string|max:255',
            'fechaNac' => 'required|date',
            'sexo' => 'required|string|max:255',
            'estadoActivo' => 'required|string|max:255',
            'correoPersonal' => 'required|email|max:255|unique:usuario,correoPersonal',
            'correoInstitucional' => 'required|email|max:255|unique:usuario,correoInstitucional',
            'matricula' => 'required|string|max:255|unique:usuario,matricula',
            'tipoUsuario' => 'required|exists:tipo_usuario,idTipo_usuario',
            'programaEducativo' => 'required|exists:programaEducativo,idProgramaEducativo',
        ]);

        // Generar una contraseña aleatoria
        $contraseniaGenerada = Str::random(8);

        // Crear un nuevo usuario (alumno)
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

        return redirect()->route('usuarioProfesor.index')->with('success', 'Alumno creado correctamente y las credenciales han sido enviadas.');

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

     //Función para mostrar la vista editar usuarios
    public function edit($id)
    {
        $usuario = Usuarios::findOrFail($id);

        $programas = ProgramasEducativos::where('estado', 1)->get();
        $tipoAlumno = TipoUsuario::where('tipo', 'Alumno')->first();

    
        return view('usuariosProfesor.edit', compact('programas' ,'usuario'))
        ->with('tipoAlumno', $tipoAlumno->idTipo_usuario);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //Función para actilizar los valores editados del usuario
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidoP' => 'required|string|max:255',
            'apellidoM' => 'required|string|max:255',
            'fechaNac' => 'required|date',
            'sexo' => 'required|string|max:255',
            'estadoActivo' => 'required|string|max:255',
            'correoPersonal' => 'required|email|max:255',
            'correoInstitucional' => 'required|email|max:255',
            'matricula' => 'required|string|max:255',
            'tipoUsuario' => 'required|exists:tipo_usuario,idTipo_usuario',
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


        // Obtener el registro de AlumnosCreados asociado al usuario
        $alumnoCreado = AlumnosCreados::where('fk_idAlumnoC', $usuario->idUsuario)
        ->where('fk_idProfesorCreador', auth()->user()->idUsuario)
        ->first();


        if ($alumnoCreado) {
            $alumnoCreado->fechaActualizacion = now();
            $alumnoCreado->save(); 
        }
        return redirect()->route('usuarioProfesor.index')->with('success', 'Alumno actualizado correctamente.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //Función para eliminar(desactivar) un usuario
    public function destroy($id)
    {
        $usuario = Usuarios::findOrFail($id);

        if ($usuario->estadoActivo == '0') {
            return redirect()->route('usuarioProfesor.index')->with('error', 'El usuario ya está inactivo y no puede ser inactivado de nuevo.');
        }

        // Cambiar el estado del usuario a inactivo
        $usuario->estadoActivo = '0'; 
        $usuario->save();

        return redirect()->route('usuarioProfesor.index')->with('success', 'Alumno desactivado correctamente.');
    }
}

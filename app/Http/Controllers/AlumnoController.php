<?php

namespace App\Http\Controllers;
use App\Models\Avisos; 
use App\Models\CuestionarioAlumno; 
use App\Models\Usuarios;
use App\Models\Cuestionarios;
use App\Models\RespuestasCuestionarios;
use App\Models\EvaluacionEstres;
use App\Models\Pasatiempos;
use App\Models\Ejercicios;
use App\Models\Materias;
use App\Models\PasatiemposSelect;
use App\Models\EjerciciosSelect;
use App\Models\MateriasSelect;
use App\Models\AsignacionesMaterial;
use App\Models\AsignacionesEjercicios;
use App\Models\AsignacionesPasatiempos;
use App\Models\Encuestas;
use App\Models\EncuestasAlumnos;
use App\Models\RespuestasEncuestas;
use App\Models\NivelesSatisfaccion;
use App\Models\Foro;
use App\Models\ComentariosForo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AlumnoController extends Controller
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



    //En esta función se obtienen los avisos para mostrarse en el inicio de los alumnos
    public function alumnoInicio()
    {
        
        // Obtiene todos los avisos
        $avisos = Avisos::all();
        return view('usuariosAlumno.index', compact('avisos'));
    }



    // En esta función se obtienen las notificaciones de los alumnos
    public function obtenerNotificaciones(){
        $usuarioActual = auth()->id();

        // Obtiene publicaciones recientes (excluyendo las del usuario actual)
        $publicaciones = Foro::where('fk_idUsuario', '!=', $usuarioActual)
            ->orderBy('fechaPublicacion', 'desc')
            ->take(5)
            ->get();

        // Obteniene los comentarios en publicaciones del usuario actual
        $comentarios = ComentariosForo::whereHas('publicacion', function ($query) use ($usuarioActual) {
            $query->where('fk_idUsuario', $usuarioActual);
        })
            ->orderBy('fechaComentario', 'desc')
            ->take(5)
            ->get();

        return response()->json([
            'publicaciones' => $publicaciones,
            'comentarios' => $comentarios,
        ]);
    }


    //Obtiene los cuestionarios asignados del alumno autenticado
    public function alumnoCuestionario()
    {
         $idAlumno = auth()->user()->idUsuario;

        // Obtiene los cuestionarios asignados al alumno que NO están marcados como "contestados"
        $cuestionariosAsignados = CuestionarioAlumno::with('cuestionario')
            ->where('fk_idAlumno', $idAlumno)
            ->get();
        

        return view('usuariosAlumno.cuestionario', compact('cuestionariosAsignados'));
        
    }



    //En esta función se obtienen los valores del cuestionarios para ser mostrado a loas alumnos
    public function mostrarCuestionario($idCuestionario, $idCuestionarioAlumno){
        // Obteniene el ID del alumno autenticado
        $idAlumno = auth()->user()->idUsuario;

        $ejercicios = Ejercicios::all();
        $pasatiempos = Pasatiempos::all();

        $materias = Materias::all();

        // Verifica si el cuestionario está asignado a este alumno y cargar sus preguntas
        $cuestionario = Cuestionarios::with('preguntas')
                                  ->where('idCuestionario', $idCuestionario)
                                  ->first();

        $cuestionarioAsignado = CuestionarioAlumno::find($idCuestionarioAlumno);


        if (!$cuestionario) {
            return redirect()->back()->with('error', 'Cuestionario no encontrado.');
        }



        return view('usuariosAlumno.preguntasCuestionario', compact('cuestionario', 'ejercicios', 'pasatiempos', 'materias', 'cuestionarioAsignado'));
    }




    //En esta función se guardan las respuestas del cuestionario del alumno
    public function guardarRespuestas(Request $request){
        $idCuestionario = $request->idCuestionario;
        $idCuestionarioAlumno = $request->idCuestionarioAlumno;
        $alumnoId = Auth::user()->idUsuario;
        $respuestas = $request->respuestas ?? [];
        $ejercicios = $request->ejercicios ?? [];
        $pasatiempos = $request->pasatiempos ?? [];
        $materias = $request->materias ?? [];
        $puntajeTotal = 0;
    

        foreach ($respuestas as $idPregunta => $valorRespuesta) {
            $respuesta = new RespuestasCuestionarios();
            $respuesta->fechaRegistro = now();
            $respuesta->valor_respuesta = $valorRespuesta;
            $respuesta->fk_idPreguntaCuestionario = $idPregunta;
            $respuesta->fk_usuario = $alumnoId;
    
            // Acumula el puntaje total
            $puntajeTotal += $valorRespuesta;
    
            $respuesta->save();
        }


        // Guarda los pasatiempos seleccionados sin duplicar
        if ($request->has('pasatiempos')) {
            foreach ($pasatiempos as $pasatiempoId) {
                $existePasatiempo = PasatiemposSelect::where('idUsuario', $alumnoId)
                    ->where('idPasatiempo', $pasatiempoId)
                    ->exists();

                if (!$existePasatiempo) {
                    $pasatiempoSelect = new PasatiemposSelect();
                    $pasatiempoSelect->idPasatiempo = $pasatiempoId;
                    $pasatiempoSelect->idUsuario = $alumnoId;
                    $pasatiempoSelect->fechaSeleccion = now();
                    $pasatiempoSelect->save();
                }
            }
        }

        // Guarda los ejercicios seleccionados sin duplicar
        if ($request->has('ejercicios')) {
            foreach ($ejercicios as $ejercicioId) {
                $existeEjercicio = EjerciciosSelect::where('idUsuario', $alumnoId)
                    ->where('idEjercicio', $ejercicioId)
                    ->exists();

                if (!$existeEjercicio) {
                    $ejercicioSelect = new EjerciciosSelect();
                    $ejercicioSelect->idEjercicio = $ejercicioId;
                    $ejercicioSelect->idUsuario = $alumnoId;
                    $ejercicioSelect->fechaSeleccion = now();
                    $ejercicioSelect->save();
                }
            }
        }

        // Guarda las materias seleccionados en la tabla MateriasSelec
        if ($request->has('materias')) {
            foreach ($request->materias as $materiaId) {
                $materiaSelect = new MateriasSelect();
                $materiaSelect->fk_idMateria = $materiaId; 
                $materiaSelect->fk_idUsuario = $alumnoId; 
                $materiaSelect->fechaSeleccion = now(); 
                $materiaSelect->save();

            }
        }

    
        //En este llamado de la función se obtiene el Nivel de estrés basado en el puntaje total
        $nivelEstres = $this->calcularNivelEstres($puntajeTotal);
    
        // Guarda el nivel de estrés en el nuevo modelo
        $evaluacionEstres = new EvaluacionEstres();
        $evaluacionEstres->fk_usuario = $alumnoId;
        $evaluacionEstres->fk_idCuestionario = $idCuestionario;
        $evaluacionEstres->puntajeTotal = $puntajeTotal;
        $evaluacionEstres->nivelEstres = $nivelEstres;
        $evaluacionEstres->save(); // Guardar en la base de datos


         // Utiliza el idCuestionarioAlumno para actualizar el estado
        $cuestionarioAlumno = CuestionarioAlumno::find($idCuestionarioAlumno);

        if ($cuestionarioAlumno) {
            $cuestionarioAlumno->estado = 'Contestado';
            $cuestionarioAlumno->save();
        }

        return redirect()->route('alumno.detalleEvaluacion')->with('success', 'Cuestionario completado.');
    }


    //Esta función calcula el nivel de estres del alumno en base al puntaje total
    private function calcularNivelEstres($puntajeTotal){
        // Determina el nivel de estrés según el puntaje total
        if ($puntajeTotal <= 23) {
            return 'Sin estrés';
        } elseif ($puntajeTotal <=46) {
            return 'Sin estrés';
        }elseif ($puntajeTotal <=69) {
            return 'Estrés leve';
        }elseif ($puntajeTotal <=92) {
            return 'Estrés medio';
        } else {
            return 'Estrés alto';
        }
    }




    //En esta función se obtienen las encuestas asiganadas a los alumnos
    public function alumnoEncuesta(){
         $idAlumno = auth()->user()->idUsuario;

         // Obtiene las encuestas asignadas al alumno
         $encuestasAsignadas = EncuestasAlumnos::with('encuesta')
                             ->where('fk_idAlumnoE', $idAlumno)
                             ->get();

         return view('usuariosAlumno.encuesta', compact('encuestasAsignadas'));

    }



    //Esta función muestra al alumno las preguntas asoaciadas a la encuesta asignada
    public function mostrarEncuesta($idEncuesta, $idEncuestaAlumno){
        $idAlumno = auth()->user()->idUsuario;

        // Verifica si la encuesta está asignada a este alumno y carga sus preguntas
        $encuesta = Encuestas::with('preguntas')
                                  ->where('idencuesta', $idEncuesta)
                                  ->first();

        
        $encuestaAsignada = EncuestasAlumnos::find($idEncuestaAlumno);                         

        if (!$encuesta) {
            return redirect()->back()->with('error', 'Encuesta no encontrada.');
        }

        return view('usuariosAlumno.preguntasEncuesta', compact('encuesta', 'encuestaAsignada'));
    }



    //Función para guardar las respuestas de la encuesta del alumno
    public function guardarRespuestasEncuesta(Request $request) {
        $idencuesta = $request->idencuesta;
        $idEncuestaAlumno = $request->idEncuestaAlumno;
        $alumnoId = Auth::user()->idUsuario;
        $respuestas = $request->respuestas ?? [];
        $puntajeTotal = 0;
        $totalPreguntas = count($respuestas);
        $comentario = $request->input('comentario');
    
        // Itera sobre las respuestas y acumula el puntaje total
        foreach ($respuestas as $idPregunta => $valorRespuesta) {
            $respuesta = new RespuestasEncuestas();
            $respuesta->fechaRegistro = now();
            $respuesta->valor_respuesta = $valorRespuesta;
            $respuesta->fk_idPreguntaEncuesta = $idPregunta;
            $respuesta->fk_idUsuario = $alumnoId;
    
            
            $puntajeTotal += $valorRespuesta;
    

            $respuesta->save();
        }
    
        // Esta llamada de la función Calcula el nivel de satisfacción basado en el puntaje total
        $nivelSatisfaccion = $this->calcularNivelSatisfaccion($puntajeTotal, $totalPreguntas);
    
        // Guarda el nivel de satisfacción en el modelo NivelesSatisfaccion
        $nivelSatisfaccionModel = new NivelesSatisfaccion();
        $nivelSatisfaccionModel->fk_encuestaContestada = $idencuesta;
        $nivelSatisfaccionModel->fk_alumnoNivel = $alumnoId;
        $nivelSatisfaccionModel->nivel = $nivelSatisfaccion;
        $nivelSatisfaccionModel->save();


        // Guarda el comentario en la tabla EncuestasAlumnos
        $encuestaAlumno = EncuestasAlumnos::find($idEncuestaAlumno);



        if ($encuestaAlumno) {
            $encuestaAlumno->comentario = $comentario;
            $encuestaAlumno->estado='Contestado';
            $encuestaAlumno->save();  
        }

        $usuario = Usuarios::findOrFail($alumnoId);
        $encuesta = Encuestas::findOrFail($idencuesta);

        // Enviar correo notificando que se respondio una encuesta
        Mail::send('emails.encuestaRespondida', [
            'nombre' => $usuario->nombre,
            'apellidoP' => $usuario->apellidoP,
            'apellidoM' => $usuario->apellidoM,
            'objetivo' => $encuesta->objetivo
        ], function($message) use ($usuario) {
            $message->to($usuario->correoInstitucional);
            $message->subject('Asignación de encuesta');
        });

        
    
        return redirect()->route('alumno.detalleEvaluacion')->with('success', 'Encuesta completada.');
    }
    

    //Esta función calcula el nivel de satisfacción del alumno con los ejercicios y pasatiempos asiganados
    private function calcularNivelSatisfaccion($puntajeTotal, $totalPreguntas) {
        // Calcular el puntaje máximo posible
        $maximoPuntaje = $totalPreguntas * 5;
    
        // Calcula los rangos dividiendo el puntaje máximo entre 5, 4, 3, 2 y 1
        $rangoPor5 = $maximoPuntaje / 5;
        $rangoPor4 = ($maximoPuntaje / 4)*2;
        $rangoPor3 = ($maximoPuntaje / 3)*2;
        $rangoPor2 = ($maximoPuntaje / 2)*1.8;
        $rangoPor1 = $maximoPuntaje / 1;
    
        // Determina el nivel de satisfacción basado en el puntaje total
        if ($puntajeTotal <= $rangoPor5) {
            return 'Bajo';
        } elseif ($puntajeTotal <= $rangoPor4) {
            return 'Bajo-Medio ';
        } elseif ($puntajeTotal <= $rangoPor3) {
            return 'Medio';
        } elseif ($puntajeTotal <= $rangoPor2) {
            return 'Medio-Alto';
        } else {
            return 'Alto';
        }
    }


    //Función que muestra los detalles de la evaluación asignado al alumno
    public function alumnoEvaluacion(){
        return view('usuariosAlumno.detalleEvaluacion');
    }


    //Función que muestra los ejercicios asignados a los alumnos
    public function alumnoEjercicio(){
        $idAlumno = auth()->user()->idUsuario;

        // Obtiene las asignaciones de ejercicios para el alumno
        $asignaciones = AsignacionesMaterial::where('idUsuario_alumno', $idAlumno)
                                        ->with('ejercicio.ejercicio')
                                        ->get();

        // Organiza los ejercicios por categorías
        $ejerciciosPorCategoria = [
            'Relajación' => [],
            'Ejercitación' => [],
            'Estiramiento' => [],
            'Cardio' => [],
            'Baile' => []
        ];

        foreach ($asignaciones as $asignacion) {
            foreach ($asignacion->ejercicio as $ejercicioAsignado) {
                $categoria = $ejercicioAsignado->ejercicio->tipo;
                $ejerciciosPorCategoria[$categoria][] = $ejercicioAsignado->ejercicio;
            }
        }

        return view('usuariosAlumno.ejercicios', compact('ejerciciosPorCategoria'));
    }


    //Esta función obtiene y manda a mostrar los detalles(imagen, video y descripción) de cada ejercicio
    public function detalleEjercicio($idEjercicio){
        $ejercicio = Ejercicios::find($idEjercicio);
        return view('usuariosAlumno.detalleEjercicio', compact('ejercicio'));
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

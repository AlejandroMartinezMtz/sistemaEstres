<?php

namespace App\Http\Controllers;

use App\Models\Encuestas; 
use App\Models\ProgramasEducativos; 
use App\Models\Usuarios; 
use App\Models\AlumnosCreados; 
use App\Models\PreguntasEncuestas; 
use App\Models\RespuestasEncuestas;
use App\Models\EncuestasAlumnos; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class EncuestasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //Función que redirige a ka vista principal de encuestas
    public function index(Request $request)
    {
         $search = $request->input('search');


         // Si existe un término de búsqueda, filtra las encuestas
         $encuestas = Encuestas::with('preguntas.respuestas','alumnos.alumno', 'preguntas', 'alumnos') // Cargar las preguntas relacionadas
         ->when($search, function ($query, $search) {
             return $query->where('objetivo', 'LIKE', "%{$search}%")
                 ->orWhere('fechaAplica', 'LIKE', "%{$search}%")
                 ->orWhere('estadoActivo', 'LIKE', "%{$search}%");
         })->get();
 

         return view('encuestas.index', compact('encuestas'));
 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Función que redirige a la vista crear una encuesta
    public function create()
    {
        $profesorId = auth()->user()->idUsuario;

        $programas = ProgramasEducativos::all();

        $alumnosCreados = AlumnosCreados::where('fk_idProfesorCreador', $profesorId)->with('usuarioAlumno')->get();

        return view('encuestas.create', compact('programas', 'alumnosCreados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     //Función que permite guardar una nueva encuestas
    public function store(Request $request)
    {

        $request->validate([
            'objetivo' => 'required|string|max:255',
            'estadoActivo' => 'required|integer',
            'preguntas' => 'nullable|array',
            'alumnos' => 'nullable|array',
        ]);

         $encuesta = new Encuestas();
         $encuesta->fechaAplica = now();
         $encuesta->objetivo = $request->objetivo;
         $encuesta->estadoActivo = $request->estadoActivo;
         $encuesta->fk_idAutor = Auth::user()->idUsuario;
         $encuesta->save();
 
        foreach ($request->preguntas as $preguntaData) {
            if (is_array($preguntaData) && isset($preguntaData['texto'])) {
                $pregunta = new PreguntasEncuestas();
                $pregunta->textoPregunta = $preguntaData['texto']; 
                $pregunta->fk_idEncuesta = $encuesta->idencuesta;
                $pregunta->save();
            }
        }
 
         // Guardar los alumnos seleccionados en la tabla EncuestaAlumno
        if ($request->has('alumnos')) {
            foreach ($request->alumnos as $alumnoId) {
                $encuestaAlumno = new EncuestasAlumnos();
                $encuestaAlumno->fk_idEncuestaE = $encuesta->idencuesta; 
                $encuestaAlumno->fk_idAlumnoE = $alumnoId;  // ID del alumno seleccionado
                $encuestaAlumno->save();


                 // Obtener la información del alumno para el envío de correos
                 $alumno = Usuarios::find($alumnoId);

                 // Enviar correo con la notificación de la encuesta
                 Mail::send('emails.encuestas', [
                     'nombre' => $alumno->nombre,  // Nombre del alumno
                     'objetivo' => $encuesta->objetivo, 
                 ], function($message) use ($alumno) {
                     $message->to($alumno->correoInstitucional);  // Correo institucional del alumno
                     $message->subject('Nueva encuesta asignada');  // Asunto del correo
                 });
            }
        }
 
 
         return redirect()->route('encuestaProfesor.index')->with('success', 'Encuesta creada correctamente.');
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

     //función que manda a la vista editar encuesta
    public function edit($id)
    {
         $profesorId = auth()->user()->idUsuario;

         // Obtener la Encuesta con las preguntas y los alumnos asociados
         $encuestas = Encuestas::with('alumnos')->findOrFail($id);
 
         $alumnosCreados = AlumnosCreados::where('fk_idProfesorCreador', $profesorId)
         ->with('usuarioAlumno')->get();
 
         return view('encuestas.edit', compact('encuestas', 'alumnosCreados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //Función que permite actualizar los datos de una encuesta
    public function update(Request $request, $id)
    {
        $request->validate([
            'objetivo' => 'required|string|max:255',
            'estadoActivo' => 'required|integer',
            'preguntas' => 'nullable|array',
            'alumnos' => 'nullable|array',
        ]);

        // Encontrar la encuesta
        $encuesta = Encuestas::findOrFail($id);

        // Actualizar los campos de la encuesta
        $encuesta->objetivo = $request->objetivo;
        $encuesta->estadoActivo = $request->estadoActivo;
        $encuesta->save();

        // Actualizar las preguntas
        if ($request->has('preguntas')) {
            foreach ($request->preguntas as $idPregunta => $data) {
                if (is_array($data)) {
                    if (isset($data['eliminar']) && $data['eliminar'] == 1) {
                        $tieneRespuestas = RespuestasEncuestas::where('fk_idPreguntaEncuesta', $idPregunta)->exists();
        
                        if (!$tieneRespuestas) {
                            PreguntasEncuestas::where('idPreguntaEncuesta', $idPregunta)->delete();
                        } else {
                            $pregunta = PreguntasEncuestas::find($idPregunta);
                            $pregunta->estadoActivo = 0;
                            $pregunta->save();
                        }
                    } else {
                        // Si la pregunta no es nueva y no se marca para eliminar, se actualiza
                        $pregunta = PreguntasEncuestas::find($idPregunta);
                        if ($pregunta) {
                            $pregunta->textoPregunta = $data['texto'];
                            $pregunta->save();
                        } else {
                            // Si es una nueva pregunta se crea
                            $nuevaPregunta = new PreguntasEncuestas();
                            $nuevaPregunta->textoPregunta = $data['texto'];
                            $nuevaPregunta->fk_idEncuesta = $encuesta->idencuesta;
                            $nuevaPregunta->save();
                        }
                    }
                }
            }
        }

        // Actualizar los alumnos de las encuestas
        // Si el estado es activo y no hay alumnos seleccionados, se elimina las relaciones de EncuestaAlumno
        if ($request->estadoActivo == 0 || empty($request->alumnos)) {
            EncuestasAlumnos::where('fk_idEncuestaE', $id)->delete();
        } else {
            EncuestasAlumnos::where('fk_idEncuestaE', $id)->delete();
            foreach ($request->alumnos as $alumnoId) {
            EncuestasAlumnos::updateOrCreate(
                ['fk_idEncuestaE' => $encuesta->idencuesta, 'fk_idAlumnoE' => $alumnoId],
                ['fk_idEncuestaE' => $encuesta->idencuesta, 'fk_idAlumnoE' => $alumnoId]
            );
            }
        }

        return redirect()->route('encuestaProfesor.index')->with('success', 'Encuesta actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //Esta función permite eliminar una encuesta y sus valores asociados mediante su id
    public function destroy($id)
    {
        $encuesta = Encuestas::findOrFail($id);


        // Elimina las preguntas asociadas a la encuesta
        $encuesta->respuestas()->delete();
        $encuesta->preguntas()->delete();
        $encuesta->alumnos()->delete();
        $encuesta->nivel()->delete();

        // Elimina la encuesta
        $encuesta->delete();

        return redirect()->route('encuestaProfesor.index')->with('success', 'Encuesta eliminada correctamente.');
    }
}

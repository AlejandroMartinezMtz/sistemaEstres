<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuestionarios; 
use App\Models\ProgramasEducativos; 
use App\Models\Usuarios; 
use App\Models\AlumnosCreados; 
use App\Models\PreguntasCuestionarios; 
use App\Models\RespuestasCuestionarios; 
use App\Models\CuestionarioAlumno; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CuestionariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     //Esta función redirige a la vista principal de cuestionarios
    public function index(Request $request)
    {
        $search = $request->input('search');


        // Si existe un término de búsqueda, filtra los cuestionarios
        $cuestionarios = Cuestionarios::with('preguntas','alumnos.alumno', 'preguntas.respuestas') // Carga las preguntas relacionadas
        ->when($search, function ($query, $search) {
            return $query->where('titulo', 'LIKE', "%{$search}%")
                ->orWhere('descripcion', 'LIKE', "%{$search}%")
                ->orWhere('fechaRegistro', 'LIKE', "%{$search}%")
                ->orWhere('puntajeMaximo', 'LIKE', "%{$search}%")
                ->orWhere('estadoActivo', 'LIKE', "%{$search}%");
        })->get();

        

        $alumnos = Usuarios::where('fk_tipo_usuario', 3)
        ->where('estadoActivo', 1) 
        ->with('programaEducativo')
        ->get()
        ->groupBy(function ($alumno) {
            return $alumno->programaEducativo->nombre;
        })
        ->map(function ($grupo) {
            return $grupo->groupBy(function ($alumno) {
                return $alumno->programaEducativo->nivel;
            });
        });



        return view('cuestionarios.index', compact('cuestionarios', 'alumnos'));
    }



    //Esta función guarda el cuestionario asiganado a los alumnos
    public function asignarCuestionario(Request $request)
    {
        $cuestionarioId = $request->input('fk_idCuestionario');
        $alumnos = $request->input('alumnos');
    
        if ($request->has('alumnos')) {
            foreach ($alumnos as $alumnoId) {
                $cuestionarioAlumno = new CuestionarioAlumno();
                $cuestionarioAlumno->fk_idCuestionario = $cuestionarioId;
                $cuestionarioAlumno->fk_idAlumno = $alumnoId;
                $cuestionarioAlumno->save();


                $alumno = Usuarios::find($alumnoId);

                $cuestionario = Cuestionarios::find($cuestionarioId );

    

                Mail::send('emails.cuestionarios', [
                    'nombre' => $alumno->nombre,
                    'tituloCuestionario' => $cuestionario->titulo,
                    'descripcion' => $cuestionario->descripcion,
                ], function($message) use ($alumno) {
                    $message->to($alumno->correoInstitucional);
                    $message->subject('Nuevo cuestionario asignado');
                });
         }
        }
    
        return redirect()->back()->with('success', 'Cuestionario asignado a los alumnos seleccionados.');
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Esta función manda a la vista crear un cuestionario
    public function create()
    {
        // Obtener el ID del profesor autenticado
        $profesorId = auth()->user()->idUsuario;

        // Obtener la lista de programas educativos
        $programas = ProgramasEducativos::all();

        // Obtener los alumnos creados por el profesor autenticado
        $alumnosCreados = AlumnosCreados::where('fk_idProfesorCreador', $profesorId)->with('usuarioAlumno')->get();

        // Retornar la vista de creación del cuestionario con los programas y alumnos creados
        return view('cuestionarios.create', compact('programas', 'alumnosCreados'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     //Esta función guarda los cuestionarios asiganados a los alumnos
    public function store(Request $request)
    {

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estadoActivo' => 'required|integer',
            'preguntas' => 'nullable|array',
            'alumnos' => 'nullable|array',
        ]);


        $cuestionario = new Cuestionarios();
        $cuestionario->titulo = $request->titulo;
        $cuestionario->descripcion = $request->descripcion;
        $cuestionario->fechaRegistro = now();
        $cuestionario->estadoActivo = $request->estadoActivo;
        $cuestionario->fk_Autor = Auth::user()->idUsuario;
        $cuestionario->puntajeMaximo = count($request->preguntas) * 5; 
        $cuestionario->save();

        foreach ($request->preguntas as $preguntaData) {
            if (is_array($preguntaData) && isset($preguntaData['texto'])) {
                $pregunta = new PreguntasCuestionarios();
                $pregunta->textoPregunta = $preguntaData['texto'];
                $pregunta->fk_idCuestionario = $cuestionario->idCuestionario;
                $pregunta->save();
            }
        }
        
        // Guardar los alumnos seleccionados en la tabla CuestionarioAlumno
        if ($request->has('alumnos')) {
            foreach ($request->alumnos as $alumnoId) {
                $cuestionarioAlumno = new CuestionarioAlumno();
                $cuestionarioAlumno->fk_idCuestionario = $cuestionario->idCuestionario;
                $cuestionarioAlumno->fk_idAlumno = $alumnoId;
                $cuestionarioAlumno->save();

                $alumno = Usuarios::find($alumnoId);

                // Enviar correo con la notificación del cuestionario
                Mail::send('emails.cuestionarios', [
                    'nombre' => $alumno->nombre, 
                    'tituloCuestionario' => $cuestionario->titulo, 
                    'descripcion' => $cuestionario->descripcion,  // Título del cuestionario
                ], function($message) use ($alumno) {
                    $message->to($alumno->correoInstitucional);  // Correo institucional del alumno
                    $message->subject('Nuevo cuestionario asignado');  // Asunto del correo
                });
            }
        }

        return redirect()->route('cuestionarioProfesor.index')->with('success', 'Cuestionario creado correctamente.');
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

    //Esta función permite editar los cuestionarios existentes
    public function edit($id)
    {
        $profesorId = auth()->user()->idUsuario;

        // Obtener el cuestionario con las preguntas y los alumnos asociados
        $cuestionarios = Cuestionarios::with('alumnos')->findOrFail($id);


        $alumnosCreados = AlumnosCreados::where('fk_idProfesorCreador', $profesorId)
        ->with('usuarioAlumno')->get();

        return view('cuestionarios.edit', compact('cuestionarios', 'alumnosCreados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //Esta función permite actualizar la información de un cuestionario
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estadoActivo' => 'required|integer',
            'preguntas' => 'nullable|array',
            'alumnos' => 'nullable|array',
        ]);

        $cuestionario = Cuestionarios::findOrFail($id);

        // Actualizar los campos del cuestionario
        $cuestionario->titulo = $request->titulo;
        $cuestionario->descripcion = $request->descripcion;
        $cuestionario->estadoActivo = $request->estadoActivo;
        $cuestionario->puntajeMaximo = count($request->preguntas) * 5;
        $cuestionario->save();

        // Actualizar las preguntas
        if ($request->has('preguntas')) {
            foreach ($request->preguntas as $idPregunta => $data) {
                // Verificar si se marcó para eliminar
                if (isset($data['eliminar']) && $data['eliminar'] == 1) {
                    // Verificar si la pregunta tiene respuestas asociadas
                    $tieneRespuestas = RespuestasCuestionarios::where('fk_idPreguntaCuestionario', $idPregunta)->exists();
                
                    if (!$tieneRespuestas) {
                        // Si no tiene respuestas, se elimina
                        PreguntasCuestionarios::where('idPreguntaInstrumento', $idPregunta)->delete();
                    } else {
                        $pregunta = PreguntasCuestionarios::find($idPregunta);
                        $pregunta->estadoActivo = 0; 
                        $pregunta->save();
                    }
                } else {
                    $pregunta = PreguntasCuestionarios::find($idPregunta);
                    if ($pregunta) {
                        $pregunta->textoPregunta = $data['texto'];
                        $pregunta->save();
                    } else {
                        $nuevaPregunta = new PreguntasCuestionarios();
                        $nuevaPregunta->textoPregunta = $data['texto'];
                        $nuevaPregunta->fk_idCuestionario = $cuestionario->idCuestionario;
                        $nuevaPregunta->save();
                    }
                }
            }
        }

        if ($request->estadoActivo == 0 || empty($request->alumnos)) {
            CuestionarioAlumno::where('fk_idCuestionario', $id)->delete();
        } else {
            CuestionarioAlumno::where('fk_idCuestionario', $id)->delete();
            foreach ($request->alumnos as $alumnoId) {
                CuestionarioAlumno::updateOrCreate(
                    ['fk_idCuestionario' => $cuestionario->idCuestionario, 'fk_idAlumno' => $alumnoId],
                    ['fk_idCuestionario' => $cuestionario->idCuestionario, 'fk_idAlumno' => $alumnoId]
                );
            }
        }

        return redirect()->route('cuestionarioProfesor.index')->with('success', 'Cuestionario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //Esta función permite eliminar un cuestionario junto con sus, respuestas, preguntas, alumnos y evaluaciones asociadas
    public function destroy($id)
    {
        $cuestionario = Cuestionarios::findOrFail($id);


        // Elimina los valores asociados al cuestionario
        $cuestionario->respuestas()->delete();
        $cuestionario->preguntas()->delete();
        $cuestionario->alumnos()->delete();
        $cuestionario->evaluacion()->delete();

        
        $cuestionario->delete();

        return redirect()->route('cuestionarioProfesor.index')->with('success', 'Cuestionario eliminado correctamente.');
    }
}

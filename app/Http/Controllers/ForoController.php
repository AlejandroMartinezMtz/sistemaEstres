<?php

namespace App\Http\Controllers;
use App\Models\Foro;
use App\Models\ComentariosForo;
use App\Models\Usuarios;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;


class ForoController extends Controller
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

    //función que valida y crea una nueva publicación
    public function crearPublicacion(Request $request)  
    {
        // Validar y guardar la publicación
        $publicacion = new Foro();
        $publicacion->fk_idUsuario = auth()->id();
        $publicacion->texto = $request->input('texto');
    
        if ($request->hasFile('imagenUrl')) {
            $file = $request->file('imagenUrl');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/foro'), $filename);
            $rutaImagen = 'images/foro/' . $filename;
            $publicacion->imagenUrl = $rutaImagen;
        }
    
        $publicacion->fechaPublicacion = now();
        $publicacion->save();

        $idCreador = $publicacion->fk_idUsuario;
        
        $alumnos = Usuarios::where('fk_tipo_usuario', 3)
        ->where('estadoActivo', 1)
        ->where('idUsuario', '!=', $idCreador)
        ->get();

        // Enviar correo notificando que se creó una nueva publicación
        foreach ($alumnos as $alumno) {
            Mail::send('emails.publicacionesForo', [
                'nombre' => $alumno->nombre,
                'apellidoP' => $alumno->apellidoP,
            ], function($message) use ($alumno) {
                $message->to($alumno->correoInstitucional); // Enviar a cada alumno
                $message->subject('Se compartió una nueva publicación en el foro');
            });
        }
    
        return redirect()->back();
    }


    //Función que valida y agrega un nuevo comentario a una publicación
    public function agregarComentario(Request $request, $idPublicacionForo)
    {
        $alumno = auth()->user();
    
        // Validar y guardar el comentario
        $comentario = new ComentariosForo();
        $comentario->fk_idUsuario = auth()->id();
        $comentario->fk_idPublicacionForo = $idPublicacionForo;
        $comentario->comentario = $request->input('comentario');
        $comentario->fechaComentario = now();
        $comentario->save();
    
        $publicacion = Foro::findOrFail($idPublicacionForo);
        $usuarioPublicacion = Usuarios::findOrFail($publicacion->fk_idUsuario);
    
        // Enviar correo notificando que se agregó un comentario
        Mail::send('emails.comentariosForo', [
            'nombre' => $usuarioPublicacion->nombre,
            'apellidoP' => $usuarioPublicacion->apellidoP,
            'nombreAlumno' => $alumno->nombre,
            'comentarioTexto' => $comentario->comentario
        ], function($message) use ($usuarioPublicacion) {
            $message->to($usuarioPublicacion->correoInstitucional);
            $message->subject('Se agregó un comentario en tu publicación');
        });
    
        return redirect()->back();
    }


    //Función que obtiene las publicaciones y sus comentarios asociados
    private function obtenerPublicacionesForo()
    {
        return Foro::with(['usuario', 'comentario.usuario'])->get();
    }

    //Función que muestra la vista principal de foro junto con sus publicaciones y comentarios
    public function alumnoForo()
    {
        $foro = $this->obtenerPublicacionesForo();
        return view('usuariosAlumno.foro', compact('foro'));
    }

    //Función que permite al usuario profesor ingresar al foro y gestionar publicaciones y comentarios
    public function profesorForo()
    {
        $foro = $this->obtenerPublicacionesForo();
        return view('usuariosProfesor.foro', compact('foro'));
    }


    //Función que elimina la publicación seleccioanda por el profesor
    public function eliminarPublicacion($id)
    {
        $publicacion = Foro::find($id);

        if (!$publicacion) {
            return response()->json(['message' => 'Publicación no encontrada.'], 404);
        }

        $publicacion->comentario()->delete();

        $publicacion->delete();

        return response()->json(['message' => 'Publicación eliminada exitosamente.']);
    }

    //Función que permite eliminar un comentario seleccionado por el profesor
    public function eliminarComentario($id)
    {
        $comentario = ComentariosForo::find($id);

        if (!$comentario) {
            return response()->json(['message' => 'Comentario no encontrado.'], 404);
        }

        $comentario->delete();

        return response()->json(['message' => 'Comentario eliminado exitosamente.']);
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

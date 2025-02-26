<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ejercicios; 
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class EjerciciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Función que manda a ala vista principal de ejercicios
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Si existe un término de búsqueda, filtra los ejercicios
        $ejercicios = Ejercicios::when($search, function ($query, $search) {
        return $query->where('nombre', 'LIKE', "%{$search}%")
            ->orWhere('tipo', 'LIKE', "%{$search}%");
        })->get();

        return view('ejercicios.index', compact('ejercicios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Función que manda a la vista de crear ejercicio
    public function create()
    {
        return view('ejercicios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //Función que permite guardar un nuevo ejercicio
    public function store(Request $request)
    {
        $request->validate([
            'videoUrl' => [
                'required',
                'mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime',
                'max:35720',
            ],
        ], [
            'videoUrl.mimetypes' => 'El video debe ser un archivo de tipo MP4, AVI, MPEG o QuickTime.',
            'videoUrl.max' => 'El tamaño máximo permitido para el video es de 35 MB.',
        ]);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:500',
            'imagenUrl' => 'required|image|mimes:jpeg,png,jpg,gif',
            'tipo' => 'required|string|max:255',
            'nivelDificultad' => 'required|string|max:255',
            'duracionRecomendada' => 'required|string|max:255',
            'frecuenciaRecomendada' => 'required|string|max:255',
            'beneficios' => 'required|string|max:255',
        ]);


        // Verifica si se ha subido una imagen
        if ($request->hasFile('imagenUrl') && $request->hasFile('videoUrl')) {
            // Obtiene el archivo
            $file = $request->file('imagenUrl');
        
            // Genera un nombre único para la imagen
            $filename = time() . '-' . $file->getClientOriginalName();
        
            // Mueve la imagen a la carpeta public/images
            $file->move(public_path('images/ejercicios'), $filename);
        
            // Guarda la URL de la imagen en la base de datos (solo guarda el nombre o la ruta)
            $rutaImagen = 'images/ejercicios/' . $filename;


            $video = $request->file('videoUrl');
            $videoName = time() . '-' . $video->getClientOriginalName();
            $video->move(public_path('videos/ejercicios'), $videoName);
            $rutaVideo = 'videos/ejercicios/' . $videoName;

            $ejercicio = new Ejercicios;
            $ejercicio->nombre = $request->nombre;
            $ejercicio->descripcion = $request->descripcion;
            $ejercicio->imagenUrl = $rutaImagen;
            $ejercicio->videoUrl = $rutaVideo;
            $ejercicio->tipo = $request->tipo;
            $ejercicio->nivelDificultad = $request->nivelDificultad;
            $ejercicio->duracionRecomendada = $request->duracionRecomendada;
            $ejercicio->frecuenciaRecomendada = $request->frecuenciaRecomendada;
            $ejercicio->beneficios = $request->beneficios;
            $ejercicio->fechaRegistro = now();
            $ejercicio->save();

            return redirect()->route('ejercicios.index')->with('success', 'Ejercicio creado correctamente.');

        }

       return redirect()->route('ejercicios.index')->with('error', 'Ejercicio no creado.');
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

     //Función que manda a la vista para editar un ejercicio
    public function edit($id)
    {
          // Obtener el ejercicio por su ID
          $ejercicio = Ejercicios::findOrFail($id);
          // Retornar la vista de edición con el ejercicio
          return view('ejercicios.edit', compact('ejercicio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //Función que permite actualizar los valores de un ejercicio
    public function update(Request $request, $id)
    {

        $request->validate([
            'videoUrl' => [
                'required',
                'mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime',
                'max:35720',
            ],
        ], [
            'videoUrl.mimetypes' => 'El video debe ser un archivo de tipo MP4, AVI, MPEG o QuickTime.',
            'videoUrl.max' => 'El tamaño máximo permitido para el video es de 35 MB.',
        ]);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'imagenUrl' => 'image|mimes:jpeg,png,jpg,gif|max:3000',
            'tipo' => 'required|string|max:255',
            'nivelDificultad' => 'required|string|max:255',
            'duracionRecomendada' => 'required|string|max:255',
            'frecuenciaRecomendada' => 'required|string|max:255',
            'beneficios' => 'required|string|max:255',
        ]);


        $ejercicio = Ejercicios::findOrFail($id);

        $ejercicio->nombre = $request->nombre;
        $ejercicio->descripcion = $request->descripcion;
        $ejercicio->tipo = $request->tipo;
        $ejercicio->nivelDificultad = $request->nivelDificultad;
        $ejercicio->duracionRecomendada = $request->duracionRecomendada;
        $ejercicio->frecuenciaRecomendada = $request->frecuenciaRecomendada;
        $ejercicio->beneficios = $request->beneficios;

        
        // Verifica si se ha subido una nueva imagen
        if ($request->hasFile('imagenUrl')) {
            // Elimina la imagen anterior si existe
            if ($ejercicio->imagenUrl && Storage::exists($ejercicio->imagenUrl)) {
                Storage::delete($ejercicio->imagenUrl);
            }

            // Obtiene el archivo
            $file = $request->file('imagenUrl');

            // Genera un nombre único para la imagen
            $filename = time() . '-' . $file->getClientOriginalName();

            // Mueve la imagen a la carpeta public/images
            $file->move(public_path('images/ejercicios'), $filename);

            // Guarda la URL de la imagen en la base de datos
            $ejercicio->imagenUrl = 'images/ejercicios/' . $filename;
        }


        // Verificar si se ha subido una nueva video
        if ($request->hasFile('videoUrl')) {
            // Elimina la video anterior si existe
            if ($ejercicio->videoUrl && Storage::exists($ejercicio->videoUrl)) {
                Storage::delete($ejercicio->videoUrl);
            }

            // Obtener el archivo
            $file = $request->file('videoUrl');

            // Generar un nombre único para la video
            $filename = time() . '-' . $file->getClientOriginalName();

            // Mover la video a la carpeta public/video
            $file->move(public_path('videos/ejercicios'), $filename);

            // Guardar la URL de la video en la base de datos
            $ejercicio->videoUrl = 'videos/ejercicios/' . $filename; // Guardar la ruta relativa
        }

        $ejercicio->save();

        return redirect()->route('ejercicios.index')->with('success', 'Ejercicio actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //Función que permite eliminar un ejercicio y sus funciones asociadas mediante el id
    public function destroy($id)
    {

        $ejercicio = Ejercicios::findOrFail($id);

        // Elimina ejercicioSelect
        $ejercicio->ejerciciosSeleccionados()->delete();


        //Elimina asignacionEjercicio
        $ejercicio->ejerciciosAsignados()->delete();
        
        // Elimina el ejercicio
        $ejercicio->delete();

 
         return redirect()->route('ejercicios.index')->with('success', 'Ejercicio eliminado correctamente.');
    }
}

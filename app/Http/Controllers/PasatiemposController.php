<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasatiempos; 
use App\Models\AsignacionesMaterial;
use App\Models\AsignacionesPasatiempos;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PasatiemposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Esta función muestra la vista principal de pasatiempos
    public function index(Request $request)
    {
           $search = $request->input('search');

           // Si existe un término de búsqueda, filtra los pasatiempos
           $pasatiempos = Pasatiempos::when($search, function ($query, $search) {
           return $query->where('nombre', 'LIKE', "%{$search}%")
               ->orWhere('tipo', 'LIKE', "%{$search}%");
           })->get();
   
           return view('pasatiempos.index', compact('pasatiempos'));
    }


    //Esta función muestra los pasatiempos asignados a los alumnos
    public function alumnoPasatiempo(){
        $idAlumno = auth()->user()->idUsuario;

        // Obtiene las asignaciones de ejercicios para el alumno
        $asignaciones = AsignacionesMaterial::where('idUsuario_alumno', $idAlumno)
                                        ->with('pasatiempo.pasatiempo')
                                        ->get();

        // Organiza pasatiempos por categorías
        $pasatiemposPorCategoria = [
         'Artístico' => [],
         'Deportivo' => [],
         'Intelectual' => [],
         'Social' => [],
         'Personal' => []
        ];

        foreach ($asignaciones as $asignacion) {
            foreach ($asignacion->pasatiempo as $pasatiempoAsignado) {
                $categoria = $pasatiempoAsignado->pasatiempo->tipo;
                $pasatiemposPorCategoria[$categoria][] = $pasatiempoAsignado->pasatiempo;
            }
        }

        return view('usuariosAlumno.pasatiempos', compact('pasatiemposPorCategoria'));
    }


    //Esta función muestra los detalles del pasatiempo seleccionado
    public function detallePasatiempo($idPasatiempo){
        $pasatiempo = Pasatiempos::find($idPasatiempo);
        return view('usuariosAlumno.detallePasatiempo', compact('pasatiempo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Muestra la vista crear pasatiempos
    public function create()
    {
         // Retornar la vista de edición con el pasatiempo
         return view('pasatiempos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     //Esta función permite crear un nuevo pasatiempo
    public function store(Request $request)
    {
        $request->validate([
            'videoUrl' => [
                'required',
                'mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime',
                'max:30720',
            ],
        ], [
            'videoUrl.mimetypes' => 'El video debe ser un archivo de tipo MP4, AVI, MPEG o QuickTime.',
            'videoUrl.max' => 'El tamaño máximo permitido para el video es de 30 MB.',
        ]);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:500',
            'imagenUrl' => 'required|image|mimes:jpeg,png,PNG,jpg,gif|max:3000',
            'videoUrl' => 'required|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:30720',
            'tipo' => 'required|string|max:255',
            'requerimientos' => 'required|string|max:255',
            'duracionRecomendada' => 'required|string|max:255',
        ]);



        if ($request->hasFile('imagenUrl') && $request->hasFile('videoUrl')) {
            $file = $request->file('imagenUrl');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('images/pasatiempos'), $filename);
            $rutaImagen = 'images/pasatiempos/' . $filename;
        
            $video = $request->file('videoUrl');
            $videoName = time() . '-' . $video->getClientOriginalName();
            $video->move(public_path('videos/pasatiempos'), $videoName);
            $rutaVideo = 'videos/pasatiempos/' . $videoName;
        
            $pasatiempo = new Pasatiempos;
            $pasatiempo->nombre = $request->nombre;
            $pasatiempo->descripcion = $request->descripcion;
            $pasatiempo->imagenUrl = $rutaImagen;
            $pasatiempo->videoUrl = $rutaVideo;
            $pasatiempo->tipo = $request->tipo;
            $pasatiempo->requerimientos = $request->requerimientos;
            $pasatiempo->duracionRecomendada = $request->duracionRecomendada;
            $pasatiempo->save();
        
            return redirect()->route('pasatiempos.index')->with('success', 'Pasatiempo creado correctamente.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //Esta función muestra la vista editar pasatiempo
    public function edit($id)
    {
        // Obtiene los valores del pasatiempo por su ID
        $pasatiempo = Pasatiempos::findOrFail($id);
        // Retornar la vista de edición con el pasatiempo
        return view('pasatiempos.edit', compact('pasatiempo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //Esta función permite actualizar los valores editados de un pasatiempo
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
            'videoUrl.max' => 'El tamaño máximo permitido para el video es de 30 MB.',
        ]);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'imagenUrl' => 'required|image|mimes:jpeg,png,jpg,gif|max:3000',
            'tipo' => 'required|string|max:255',
            'requerimientos' => 'required|string|max:255',
            'duracionRecomendada' => 'required|string|max:255',
        ]);


        $pasatiempo = Pasatiempos::findOrFail($id);

        $pasatiempo->nombre = $request->nombre;
        $pasatiempo->descripcion = $request->descripcion;
        $pasatiempo->tipo = $request->tipo;
        $pasatiempo->requerimientos = $request->requerimientos;
        $pasatiempo->duracionRecomendada = $request->duracionRecomendada;

        // Verifica si se ha subido una nueva imagen
        if ($request->hasFile('imagenUrl')) {
            // Elimina la imagen anterior si existe
            if ($pasatiempo->imagenUrl && Storage::exists($pasatiempo->imagenUrl)) {
                Storage::delete($pasatiempo->imagenUrl);
            }

            // Obtiene el archivo
            $file = $request->file('imagenUrl');

            // Genera un nombre único para la imagen
            $filename = time() . '-' . $file->getClientOriginalName();

            // Mueve la imagen a la carpeta public/images
            $file->move(public_path('images/pasatiempos'), $filename);

            // Guarda la URL de la imagen en la base de datos
            $pasatiempo->imagenUrl = 'images/pasatiempos/' . $filename; // Guardar la ruta relativa
        }

        // Verifica si se ha subido una nueva video
        if ($request->hasFile('videoUrl')) {
            // Elimina la video anterior si existe
            if ($pasatiempo->videoUrl && Storage::exists($pasatiempo->videoUrl)) {
                Storage::delete($pasatiempo->videoUrl);
            }

            // Obtiene el archivo
            $file = $request->file('videoUrl');

            // Genera un nombre único para la video
            $filename = time() . '-' . $file->getClientOriginalName();

            // Mueve el video a la carpeta public/video
            $file->move(public_path('videos/pasatiempos'), $filename);

            // Guarda la URL de la video en la base de datos
            $pasatiempo->videoUrl = 'videos/pasatiempos/' . $filename; // Guardar la ruta relativa
        }

        $pasatiempo->save();


        return redirect()->route('pasatiempos.index')->with('success', 'pasatiempo actualizado correctamente.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Esta función elimina el pasatiempo seleccionado por id
    public function destroy($id)
    {
          $pasatiempo = Pasatiempos::findOrFail($id);

          // Elimina pasatiempoSelect
          $pasatiempo->pasatiemposSeleccionados()->delete();


          //Elimina asignacionPasatiempo
          $pasatiempo->pasatiemposAsignados()->delete();


          // Elimina el pasatiempo
          $pasatiempo->delete();
  
          return redirect()->route('pasatiempos.index')->with('success', 'pasatiempo eliminado correctamente.');
    }
}

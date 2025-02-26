<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Avisos;
use App\Models\Usuarios;  
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class AvisosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Esta función obtiene la vista principal del alumno con los avisos publicados
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Si existe un término de búsqueda, filtra los avisos
        $avisos = Avisos::when($search, function ($query, $search) {
        return $query->where('titulo', 'LIKE', "%{$search}%")
            ->orWhere('descripcion', 'LIKE', "%{$search}%")
            ->orWhere('fechaCreacion', 'LIKE', "%{$search}%")
            ->orWhere('fechaInicio', 'LIKE', "%{$search}%");
        })->get(); 

        // Retorna la vista con los resultados filtrados o todos los avisos
        return view('avisos.index', compact('avisos'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Esta función obtiene los usuarios que crearon avisos
    public function create()
    {
        $usuarioCreador = Usuarios::all();
         // Retornar la vista de creación del aviso
         return view('avisos.create', compact('usuarioCreador') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //Esta función guarda los avisos creados
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'imagenUrl' => 'required|image|mimes:jpeg,png,jpg,gif|max:3000',
            'fechaInicio' => 'required|string|max:255',
            'fechaFin' => 'required|string|max:255',
        ]);



        // Verificar si se ha subido una imagen
    if ($request->hasFile('imagenUrl')) {
        $file = $request->file('imagenUrl');
        
        // Generar un nombre único para la imagen
        $filename = time() . '-' . $file->getClientOriginalName();
        
        // Mover la imagen a la carpeta public/images
        $file->move(public_path('images/avisos'), $filename);
        
        // Guardar la URL de la imagen en la base de datos (solo guarda el nombre o la ruta)
        $rutaImagen = 'images/avisos/' . $filename;


        $aviso = new Avisos;
        $aviso->titulo = $request->titulo;
        $aviso->descripcion = $request->descripcion;
        $aviso->imagenUrl = $rutaImagen;
        $aviso->fechaInicio = $request->fechaInicio;
        $aviso->fechaFin= $request->fechaFin;
        $aviso->id_usuarioCreador = Auth::user()->idUsuario;
        $aviso->save();

        return redirect()->route('avisos.index')->with('success', 'aviso creado correctamente.');

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //Esta función muestra la vista de editar para visos y obtiene las información del aviso a editar
    public function edit($id)
    {
        // Obtener el aviso por su ID
        $aviso = Avisos::findOrFail($id);
        // Retornar la vista de edición con el aviso
        return view('avisos.edit', compact('aviso'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //Esta función actualiza los datos del aviso editado
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'imagenUrl' => 'required|image|mimes:jpeg,png,jpg,gif|max:3000',
            'fechaInicio' => 'required|string|max:255',
            'fechaFin' => 'required|string|max:255',
        ]);


        $aviso = Avisos::findOrFail($id);

        $aviso->titulo = $request->titulo;
        $aviso->descripcion = $request->descripcion;
        $aviso->fechaInicio = $request->fechaInicio;
        $aviso->fechaFin= $request->fechaFin;
        $aviso->id_usuarioCreador = Auth::user()->idUsuario;
  
       // Verificar si se ha subido una nueva imagen
       if ($request->hasFile('imagenUrl')) {
        if ($aviso->imagenUrl && Storage::exists($aviso->imagenUrl)) {
            Storage::delete($aviso->imagenUrl);
        }

        // Obtener el archivo
        $file = $request->file('imagenUrl');

        // Generar un nombre único para la imagen
        $filename = time() . '-' . $file->getClientOriginalName();

        // Mover la imagen a la carpeta public/images
        $file->move(public_path('images/avisos'), $filename);

        // Guardar la URL de la imagen en la base de datos
        $aviso->imagenUrl = 'images/avisos/' . $filename; // Guardar la ruta relativa
    }

        $aviso->save();

        return redirect()->route('avisos.index')->with('success', 'aviso actualizado correctamente.');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //Esta función elimina el aviso seleccionado
    public function destroy($id)
    {
         $aviso = Avisos::findOrFail($id);

         // Elimina el aviso
         $aviso->delete();
 
         return redirect()->route('avisos.index')->with('success', 'Aviso eliminado correctamente.');
    }
}

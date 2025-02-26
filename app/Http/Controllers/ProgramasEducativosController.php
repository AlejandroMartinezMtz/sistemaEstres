<?php

namespace App\Http\Controllers;
use App\Models\ProgramasEducativos;
use Illuminate\Http\Request;

class ProgramasEducativosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Función que muestra la vista principal de programas educativos
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Si existe un término de búsqueda, filtra los programas
        $programas = ProgramasEducativos::when($search, function ($query, $search) {
        return $query->where('nombre', 'LIKE', "%{$search}%")
            ->orWhere('nivel', 'LIKE', "%{$search}%")
            ->orWhere('facultad', 'LIKE', "%{$search}%")
            ->orWhere('estado', 'LIKE', "%{$search}%");
        })->get();


        return view('programas.index', compact('programas'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Función que muestra la vista crear programa educativo
    public function create()
    {
         return view('programas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     //función que guarda el nuevo programa educativo
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'nivel' => 'required|integer|min:0',
            'duracion' => 'required|integer|min:0',
            'facultad' => 'required|string|max:255',
        ]);

        $programa = new ProgramasEducativos;
        $programa->nombre = $request->nombre;
        $programa->descripcion = $request->descripcion;
        $programa->nivel = $request->nivel;
        $programa->duracion = $request->duracion;
        $programa->facultad = $request->facultad;
        $programa->save();

        return redirect()->route('programas.index')->with('success', 'Programa creada correctamente.');
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

     //Función que muestra la vista de editar programa educativo
    public function edit($id)
    {
        $programa = ProgramasEducativos::findOrFail($id);
   
        return view('programas.edit', compact('programa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //Función que actualiza los valores editados de un programa educativo
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'nivel' => 'required|integer|min:0',
            'duracion' => 'required|integer|min:0',
            'facultad' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
        ]);

        $programa = ProgramasEducativos::findOrFail($id);
        $programa->nombre = $request->nombre;
        $programa->descripcion = $request->descripcion;
        $programa->nivel = $request->nivel;
        $programa->duracion = $request->duracion;
        $programa->facultad = $request->facultad;
        $programa->estado = $request->estado;
        $programa->save();

        return redirect()->route('programas.index')->with('success', 'Programa actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //Función que elimina(desactiva) un programa educativo por su id
    public function destroy($id)
    {
         $programa = ProgramasEducativos::findOrFail($id);

         // Cambia el estado a 0 (inactivo), se desactiva el programa educativo
         $programa->estado = 0;
         $programa->save();


         return redirect()->route('programas.index')->with('success', 'programa eliminado(desactivado) correctamente.');
    }
}

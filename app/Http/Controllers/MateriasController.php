<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materias;
use App\Models\ProgramasEducativos;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MateriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Muestra la vista principal de materias
    public function index(Request $request)
    {
         $search = $request->input('search');

         // Si existe un término de búsqueda, filtra los materias
         $materias= Materias::when($search, function ($query, $search) {
         return $query->where('nombre', 'LIKE', "%{$search}%")
             ->orWhere('cuatrimestre', 'LIKE', "%{$search}%")
             ->orWhere('descripcion', 'LIKE', "%{$search}%");
         })->get();
 
         return view('materias.index', compact('materias'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Esta función redirige a la vista crear materia
    public function create()
    {
        // Obtener la lista de programas educativos
        $programas = ProgramasEducativos::all(); 

        return view('materias.create', compact('programas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     //Esta función guarda una nueva materia creada
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'horaSemana' => 'required|integer|min:0',
            'cuatrimestre' => 'required|integer|min:0',
            'numeroCreditos' => 'required|integer|min:0',
            'programaEducativo' => 'required|exists:programaEducativo,idProgramaEducativo',
        ]);


        $materia = new Materias;
        $materia->nombre = $request->nombre;
        $materia->descripcion = $request->descripcion;
        $materia->horaSemana = $request->horaSemana;
        $materia->cuatrimestre = $request->cuatrimestre;
        $materia->numeroCreditos = $request->numeroCreditos;
        $materia->fk_Programa = $request->programaEducativo;
        $materia->save();


        return redirect()->route('materias.index')->with('success', 'Materia creada correctamente.');
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

     //Esta función redirige a la vista editar materia
    public function edit($id)
    {
          $materia = Materias::findOrFail($id);
  
          $programas = ProgramasEducativos::all(); 
 
          return view('materias.edit', compact('materia', 'programas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //Esta función actualiza los nuevos valores de la encuesta editada
    public function update(Request $request, $id)
    {
          // Valida los datos recibidos
          $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'horaSemana' => 'required|integer',
            'cuatrimestre' => 'required|integer',
            'numeroCreditos' => 'required|integer',
            'programaEducativo' => 'required|exists:programaEducativo,idProgramaEducativo',
        ]);

        // Obtiene la materia para actualizarla
        $materia = Materias::findOrFail($id);
        $materia->nombre = $request->nombre;
        $materia->descripcion = $request->descripcion;
        $materia->horaSemana = $request->horaSemana;
        $materia->cuatrimestre = $request->cuatrimestre;
        $materia->numeroCreditos = $request->numeroCreditos;
        $materia->fk_Programa = $request->programaEducativo;
        $materia->save();


        return redirect()->route('materias.index')->with('success', 'Materia actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //Esta función elimina la materia seleccionada por su id
    public function destroy($id)
    {
        $materia = Materias::findOrFail($id);

        $materia->materiasSelec()->delete();
        
        $materia->delete();

        return redirect()->route('materias.index')->with('success', 'Materia eliminada correctamente.');
    }
}

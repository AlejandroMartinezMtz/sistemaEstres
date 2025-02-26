<?php

namespace App\Http\Controllers;
use App\Models\Usuarios;
use App\Models\Encuestas;
use App\Models\EncuestasAlumnos;
use App\Models\EvaluacionEstres;
use App\Models\Foro;
use App\Models\ComentariosForo;
use App\Models\NivelesSatisfaccion;
use Illuminate\Http\Request;

class AdminController extends Controller
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



    //En esta función se obtienen los valores para las graficas del panel del administrador
    public function adminDashboard()
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


        return view('admin_dashboard', compact('genderData', 'surveyData', 'forumData', 'stressData'));
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

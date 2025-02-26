<?php

namespace App\Http\Controllers;
use App\Models\EvaluacionEstres;
use App\Models\NivelesSatisfaccion;
use App\Models\Cuestionarios;
use App\Models\MateriasSelect;
use App\Models\Ejercicios;
use App\Models\Pasatiempos;
use App\Models\EncuestasAlumnos;
use App\Models\Materias;
use App\Models\ProgramasEducativos;
use App\Models\Usuarios;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

use Illuminate\Http\Request;

class ReportesController extends Controller
{

    //Función que muestra la vista principal de reportes
    public function index()
    {
        $alumnos = Usuarios::where('fk_tipo_usuario', 3)
        ->where('estadoActivo', 1)
        ->get();

        return view('reportes.index', compact('alumnos'));
    }


    //Función que genera el reporte de cuestionarios
    public function cuestionario(Request $request){

        $dates = $request->query('dates');

        if (!$dates) {
            return redirect()->back()->with('error', 'Por favor, selecciona un rango de fechas.');
        }
    
        [$startDate, $endDate] = explode(' - ', $dates);
    

        $cuestionarios = EvaluacionEstres::whereBetween('fechaRegistro', [$startDate, $endDate])->get();
    
        $stressData = $cuestionarios->groupBy('nivelEstres')->map->count()->toArray();
    
        if ($request->has('export') && $request->export === 'pdf') {
            $pdf = Pdf::loadView('reportes.cuestionario', compact('cuestionarios', 'startDate', 'endDate', 'stressData'));
            return $pdf->stream('reporte-cuestionarios.pdf');
        }
    
        return view('reportes.index', compact('cuestionarios', 'stressData', 'startDate', 'endDate'));

    }

    //Función que genera el la grafica para el reporte de cuestionarios
    public function mostrarGraficaCuestionario(Request $request){
        
        $dates = $request->query('dates');

        if (!$dates) {
            return redirect()->back()->with('error', 'Por favor, selecciona un rango de fechas.');
        }
    
        [$startDate, $endDate] = explode(' - ', $dates);


        // Total de alumnos registrados
        $totalAlumnos = Usuarios::where('fk_tipo_usuario', 3)->count();

        // Cantidad de alumnos que contestaron en el rango de fechas (usuarios únicos)
        $alumnosQueContestaron = EvaluacionEstres::whereBetween('fechaRegistro', [$startDate, $endDate])
            ->select('fk_usuario')
            ->distinct()
            ->count();

        // Cálculo de porcentaje
        $porcentajeContestaron = $totalAlumnos > 0 ? ($alumnosQueContestaron / $totalAlumnos) * 100 : 0;


        return view('reportes.graficaCuestionarios', compact('totalAlumnos', 'alumnosQueContestaron', 'porcentajeContestaron', 'startDate', 'endDate'));
    }



    //Función que genera la grafica para el reporte de encuestas
    public function mostrarGraficaEncuesta(Request $request){
        
        $dates = $request->query('dates');

        if (!$dates) {
            return redirect()->back()->with('error', 'Por favor, selecciona un rango de fechas.');
        }
    
        [$startDate, $endDate] = explode(' - ', $dates);


        // Total de alumnos registrados
        $totalAlumnos = Usuarios::where('fk_tipo_usuario', 3)->count();

        // Cantidad de alumnos que contestaron en el rango de fechas (usuarios únicos)
        $alumnosQueContestaron = NivelesSatisfaccion::whereBetween('fechaRegistro', [$startDate, $endDate])
            ->select('fk_usuario')
            ->distinct()
            ->count();

        // Cálculo de porcentaje
        $porcentajeContestaron = $totalAlumnos > 0 ? ($alumnosQueContestaron / $totalAlumnos) * 100 : 0;

        return view('reportes.graficaEncuestas', compact('totalAlumnos', 'alumnosQueContestaron', 'porcentajeContestaron', 'startDate', 'endDate'));
    }


    //Función que genera la grafica para el reporte de materias
    public function mostrarGraficaMaterias(Request $request){
        $dates = $request->query('dates');
    
        if (!$dates) {
            return redirect()->back()->with('error', 'Por favor, selecciona un rango de fechas.');
        }

        // Separar el rango de fechas
        [$startDate, $endDate] = explode(' - ', $dates);

         $topMaterias = Materias::whereHas('materiasSelec', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('fechaSeleccion', [$startDate, $endDate]);
        })
        ->withCount('materiasSelec as total')
        ->orderByDesc('total')
        ->limit(5)
        ->get();

        return view('reportes.graficaMaterias', compact('topMaterias', 'startDate', 'endDate'));
    }


    //Función que genera la grafica para el reporte de ejercicios
    public function mostrarGraficaEjercicios(Request $request)
    {
        $dates = $request->query('dates');
    
        if (!$dates) {
            return redirect()->back()->with('error', 'Por favor, selecciona un rango de fechas.');
        }

        // Separar el rango de fechas
        [$startDate, $endDate] = explode(' - ', $dates);


        $topEjercicios = Ejercicios::whereHas('ejerciciosSeleccionados', function ($query) use ($startDate, $endDate) {
        $query->whereBetween('fechaSeleccion', [$startDate, $endDate]);
        })
        ->withCount('ejerciciosSeleccionados as total')
        ->orderByDesc('total')
        ->limit(5)
        ->get();

        if ($topEjercicios->isEmpty()) {
            return redirect()->back()->with('error', 'No hay información disponible para las materias.');
        }

        return view('reportes.graficaEjercicios', compact('topEjercicios', 'startDate', 'endDate'));
    }


    //Función que genera la grafica para el reporte de cuestionarios antes y despues
    public function mostrarGraficaMomentos(Request $request){

        $dates = $request->query('dates');

        if (!$dates) {
            return redirect()->back()->with('error', 'Por favor, selecciona un rango de fechas.');
        }
     
        [$startDate, $endDate] = explode(' - ', $dates);
    

        $evaluaciones = EvaluacionEstres::whereBetween('fechaRegistro', [$startDate, $endDate])
            ->with('usuario')
            ->orderBy('fechaRegistro', 'desc')
            ->get()
            ->groupBy('fk_usuario')
            ->map(function ($evaluaciones) {
                return $evaluaciones->take(2);
            })
            ->filter(function ($evaluaciones) {
                return $evaluaciones->count() == 2;
            });
    

        $alumnos = $evaluaciones->map(function ($evaluaciones) {
            return [
                'nombre' => $evaluaciones->first()->usuario->nombre,
                'antes' => $evaluaciones->last()->puntajeTotal, 
                'despues' => $evaluaciones->first()->puntajeTotal,
            ];
        });
    
        return view('reportes.graficaMomentos', compact('startDate', 'endDate', 'alumnos'));
    }
    
     
    //Función que genera la grafica para el reporte de aplicación de encuesta personalizada
    public function mostrarGraficaAplicaEncuesta(Request $request){

        $dates = $request->query('dates');
        $alumnoId = $request->query('alumno_id');

        if (!$dates || !$alumnoId) {
            return redirect()->back()->with('error', 'Por favor, selecciona un rango de fechas y un alumno.');
        }

        [$startDate, $endDate] = explode(' - ', $dates);

        // Obtener las intervenciones personalizadas para el alumno dentro del rango de fechas
        $intervenciones = EncuestasAlumnos::where('fk_idAlumnoE', $alumnoId)
        ->whereBetween('fechaAsignacion', [$startDate, $endDate])
        ->get();

        $alumno = Usuarios::find($alumnoId);
        

        if ($intervenciones->isEmpty()) {
            return redirect()->back()->with('error', 'No hay información disponible para este alumno.');
        }

        // Generar el PDF
        $pdf = PDF::loadView('reportes.graficaAplicaEncuesta', compact('alumno', 'startDate', 'endDate', 'intervenciones'));
    
        return $pdf->download('reporte_intervenciones.pdf');
    }


    //Función que genera el reporte de programas
    public function mostrarReporteProgramas(Request $request){
        $dates = $request->query('dates');

        if (!$dates) {
            return redirect()->back()->with('error', 'Por favor, selecciona un rango de fechas.');
        }

        [$startDate, $endDate] = explode(' - ', $dates);


        $programas = ProgramasEducativos::withCount(['usuarios' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('fechaRegistro', [$startDate, $endDate]);
        }])->get();

        $totalUsuarios = $programas->sum('usuarios_count');


        if ($totalUsuarios === 0) {
            return redirect()->back()->with('error', 'No hay alumnos registrados en el rango de fechas seleccionado.');
        }


        foreach ($programas as $programa) {
            $programa->porcentaje = round(($programa->usuarios_count / $totalUsuarios) * 100, 2);
        }


        $pdf = PDF::loadView('reportes.graficaProgramas', compact('programas', 'startDate', 'endDate', 'totalUsuarios'));
    
        return $pdf->download('reporte_programas.pdf');

    }

    //Función que genera la grafica para el reporte de pasatiempos
    public function mostrarGraficaPasatiempos(Request $request)
    {
        $dates = $request->query('dates');
    
        if (!$dates) {
            return redirect()->back()->with('error', 'Por favor, selecciona un rango de fechas.');
        }

        // Separar el rango de fechas
        [$startDate, $endDate] = explode(' - ', $dates);


        $topPasatiempos = Pasatiempos::whereHas('pasatiemposSeleccionados', function ($query) use ($startDate, $endDate) {
        $query->whereBetween('fechaSeleccion', [$startDate, $endDate]);
        })
        ->withCount('pasatiemposSeleccionados as total')
        ->orderByDesc('total')
        ->limit(5)
        ->get();


         if ($topPasatiempos->isEmpty()) {
            return redirect()->back()->with('error', 'No hay información disponible para las materias.');
        }



        return view('reportes.graficaPasatiempos', compact('topPasatiempos', 'startDate', 'endDate'));
    }
}

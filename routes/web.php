<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\EjerciciosController;
use App\Http\Controllers\PasatiemposController;
use App\Http\Controllers\MateriasController;
use App\Http\Controllers\ProgramasEducativosController;
use App\Http\Controllers\AvisosController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\CuestionariosController;
use App\Http\Controllers\EncuestasController;

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ForoController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\RespaldoController;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return view('login');
});

Route::get('/login', function () {
    return view('login');
})->name('login.view');



Route::resource('tipos', TipoUsuario::class);
Route::resource('programas', ProgramasEducativos::class);
Route::resource('usuarios', UsuariosController::class);
Route::resource('ejercicios', 'EjerciciosController');
Route::resource('ejercicios', EjerciciosController::class);
Route::resource('pasatiempos', EjerciciosController::class);


// Ruta para procesar el formulario de inicio de sesión
Route::post('/login', 'App\Http\Controllers\InicioSesionController@login')->name('login');
Route::post('/recuperarContrasenia', 'App\Http\Controllers\RecuperarContraseniaController@login')->name('recuperarContrasenia');





Route::get('password/forgot', [PasswordResetController::class, 'showEmailForm'])->name('password.request');
Route::post('password/send-code', [PasswordResetController::class, 'sendVerificationCode'])->name('password.send_code');

Route::get('password/verify', [PasswordResetController::class, 'showVerificationForm'])->name('password.verify');
Route::post('password/verify-code', [PasswordResetController::class, 'verifyCode'])->name('password.verify_code');

Route::get('password/reset', [PasswordResetController::class, 'showResetForm'])->name('password.reset_form');
Route::post('password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update_password');



//Ruta para cerrar sesión
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');




//Recursos para el administrador
Route::middleware(['auth', 'admin'])->group(function () {

Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
// Definición de la ruta para el dashboard
Route::get('/usuarios/dashboard', [UsuariosController::class, 'adminDashboard'])->name('usuarios.adminDashboard');





Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios.index');
// Ruta para agregar usuario (formularios)
Route::get('/usuarios/create', [UsuariosController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios', [UsuariosController::class, 'store'])->name('usuarios.store');

// Ruta para editar un usuario
Route::get('/usuarios/{usuario}/edit', [UsuariosController::class, 'edit'])->name('usuarios.edit');
Route::put('/usuarios/{usuario}', [UsuariosController::class, 'update'])->name('usuarios.update');

// Ruta para eliminar usuario
Route::delete('/usuarios/{usuario}', [UsuariosController::class, 'destroy'])->name('usuarios.destroy');






//Rutas para los ejercicios
Route::get('/ejercicios', [EjerciciosController::class, 'index'])->name('ejercicios.index');
// Ruta para agregar usuario (formularios)
Route::get('/ejercicios/create', [EjerciciosController::class, 'create'])->name('ejercicios.create');
Route::post('/ejercicios', [EjerciciosController::class, 'store'])->name('ejercicios.store');


// Ruta para editar un usuario
Route::get('/ejercicios/{ejercicio}/edit', [EjerciciosController::class, 'edit'])->name('ejercicios.edit');
Route::put('/ejercicios/{ejercicio}', [EjerciciosController::class, 'update'])->name('ejercicios.update');

// Ruta para eliminar usuario
Route::delete('/ejercicios/{ejercicio}', [EjerciciosController::class, 'destroy'])->name('ejercicios.destroy');






//Rutas para los pasatiempos
Route::get('/pasatiempos', [PasatiemposController::class, 'index'])->name('pasatiempos.index');
// Ruta para agregar usuario (formularios)
Route::get('/pasatiempos/create', [PasatiemposController::class, 'create'])->name('pasatiempos.create');
Route::post('/pasatiempos', [PasatiemposController::class, 'store'])->name('pasatiempos.store');

// Ruta para editar un usuario
Route::get('/pasatiempos/{pasatiempo}/edit', [PasatiemposController::class, 'edit'])->name('pasatiempos.edit');
Route::put('/pasatiempos/{pasatiempo}', [PasatiemposController::class, 'update'])->name('pasatiempos.update');

// Ruta para eliminar usuario
Route::delete('/pasatiempos/{pasatiempo}', [PasatiemposController::class, 'destroy'])->name('pasatiempos.destroy');





//Rutas para los materias
Route::get('/materias', [MateriasController::class, 'index'])->name('materias.index');
// Ruta para agregar materia (formularios)
Route::get('/materias/create', [MateriasController::class, 'create'])->name('materias.create');
Route::post('/materias', [MateriasController::class, 'store'])->name('materias.store');

// Ruta para editar un materia
Route::get('/materias/{materia}/edit', [MateriasController::class, 'edit'])->name('materias.edit');
Route::put('/materias/{materia}', [MateriasController::class, 'update'])->name('materias.update');

// Ruta para eliminar materia
Route::delete('/materias/{materia}', [MateriasController::class, 'destroy'])->name('materias.destroy');





//Rutas para los programas
Route::get('/programas', [ProgramasEducativosController::class, 'index'])->name('programas.index');
// Ruta para agregar programa (formularios)
Route::get('/programas/create', [ProgramasEducativosController::class, 'create'])->name('programas.create');
Route::post('/programas', [ProgramasEducativosController::class, 'store'])->name('programas.store');

// Ruta para editar un programa
Route::get('/programas/{programa}/edit', [ProgramasEducativosController::class, 'edit'])->name('programas.edit');
Route::put('/programas/{programa}', [ProgramasEducativosController::class, 'update'])->name('programas.update');

// Ruta para eliminar programa
Route::delete('/programas/{programa}', [ProgramasEducativosController::class, 'destroy'])->name('programas.destroy');






//Rutas para los avisos
Route::get('/avisos', [avisosController::class, 'index'])->name('avisos.index');
// Ruta para agregar aviso (formularios)
Route::get('/avisos/create', [avisosController::class, 'create'])->name('avisos.create');
Route::post('/avisos', [avisosController::class, 'store'])->name('avisos.store');

// Ruta para editar un aviso
Route::get('/avisos/{aviso}/edit', [avisosController::class, 'edit'])->name('avisos.edit');
Route::put('/avisos/{aviso}', [avisosController::class, 'update'])->name('avisos.update');

// Ruta para eliminar aviso
Route::delete('/avisos/{aviso}', [avisosController::class, 'destroy'])->name('avisos.destroy');


Route::get('/reportes', [ReportesController::class, 'index'])->name('reportes.index');
Route::get('/reportes/cuestionario', [ReportesController::class, 'mostrarGraficaCuestionario'])->name('reporte.mostrarGraficaCuestionario');
Route::get('/reportes/encuesta', [ReportesController::class, 'mostrarGraficaEncuesta'])->name('reporte.mostrarGraficaEncuesta');


Route::get('/reportes/materia', [ReportesController::class, 'mostrarGraficaMaterias'])->name('reporte.mostrarGraficaMaterias');
Route::get('/reportes/ejercicio', [ReportesController::class, 'mostrarGraficaEjercicios'])->name('reporte.mostrarGraficaEjercicios');


Route::get('/reportes/aplicacion-momentos', [ReportesController::class, 'mostrarGraficaMomentos'])->name('reporte.mostrarGraficaMomentos');


Route::get('/reportes/intervencion', [ReportesController::class, 'mostrarGraficaAplicaEncuesta'])->name('reporte.mostrarGraficaAplicaEncuesta');



Route::get('/reportes/programa', [ReportesController::class, 'mostrarReporteProgramas'])->name('reporte.mostrarReporteProgramas');

Route::get('/reportes/pasatiempo', [ReportesController::class, 'mostrarGraficaPasatiempos'])->name('reporte.mostrarGraficaPasatiempos');




//Recursos para el resaldo y restuaración del sistema
Route::get('/respaldos', [RespaldoController::class, 'index'])->name('respaldo.index');
Route::post('/respaldos/respaldo', [RespaldoController::class, 'respaldo'])->name('respaldos.respaldo');
Route::post('/respaldos/restaurar', [RespaldoController::class, 'restaurar'])->name('respaldos.restaurar');
Route::post('/respaldos/verificarPassword', [RespaldoController::class, 'verificarPassword'])->name('respaldos.verificarPassword');



});




//Recursos para el profesor
Route::middleware(['auth', 'profesor'])->group(function () {

Route::get('/profesor/dashboard', [ProfesorController::class, 'profesorDashboard'])->name('profesor.dashboard');
Route::get('/usuarioProfesor/dashboard', [ProfesorController::class, 'profesorDashboard'])->name('usuarios.profesorDashboard');






Route::get('/usuarioProfesor', [ProfesorController::class, 'index'])->name('usuarioProfesor.index');
// Ruta para agregar usuario (formularios)
Route::get('/usuarioProfesor/create', [ProfesorController::class, 'create'])->name('usuarioProfesor.create');
Route::post('/usuarioProfesor', [ProfesorController::class, 'store'])->name('usuarioProfesor.store');

// Ruta para editar un usuario
Route::get('/usuarioProfesor/{usuario}/edit', [ProfesorController::class, 'edit'])->name('usuarioProfesor.edit');
Route::put('/usuarioProfesor/{usuario}', [ProfesorController::class, 'update'])->name('usuarioProfesor.update');

// Ruta para eliminar usuario
Route::delete('/usuarioProfesor/{usuario}', [ProfesorController::class, 'destroy'])->name('usuarioProfesor.destroy');




//Rutas para cuestionarios
Route::get('/cuestionarioProfesor', [CuestionariosController::class, 'index'])->name('cuestionarioProfesor.index');
Route::post('/asignacionCuestionarioProfesor', [CuestionariosController::class, 'asignarCuestionario'])->name('profesor.asignarCuestionario');






// Ruta para agregar cuestionario (formularios)
Route::get('/cuestionarioProfesor/create', [CuestionariosController::class, 'create'])->name('cuestionarioProfesor.create');
Route::post('/cuestionarioProfesor', [CuestionariosController::class, 'store'])->name('cuestionarioProfesor.store');

// Ruta para editar un cuestionario
Route::get('/cuestionarioProfesor/{usuario}/edit', [CuestionariosController::class, 'edit'])->name('cuestionarioProfesor.edit');
Route::put('/cuestionarioProfesor/{usuario}', [CuestionariosController::class, 'update'])->name('cuestionarioProfesor.update');

// Ruta para eliminar cuestionario
Route::delete('/cuestionarioProfesor/{usuario}', [CuestionariosController::class, 'destroy'])->name('cuestionarioProfesor.destroy');




//Rutas para encuestas
Route::get('/encuestaProfesor', [EncuestasController::class, 'index'])->name('encuestaProfesor.index');
// Ruta para agregar encuesta (formularios)
Route::get('/encuestaProfesor/create', [EncuestasController::class, 'create'])->name('encuestaProfesor.create');
Route::post('/encuestaProfesor', [EncuestasController::class, 'store'])->name('encuestaProfesor.store');

// Ruta para editar un encuesta
Route::get('/encuestaProfesor/{encuesta}/edit', [EncuestasController::class, 'edit'])->name('encuestaProfesor.edit');
Route::put('/encuestaProfesor/{encuesta}', [EncuestasController::class, 'update'])->name('encuestaProfesor.update');

// Ruta para eliminar encuesta
Route::delete('/encuestaProfesor/{encuesta}', [EncuestasController::class, 'destroy'])->name('encuestaProfesor.destroy');




//Rutas para Modulos Especiales
Route::get('/materialProfesor', [ProfesorController::class, 'envioRecomendacion'])->name('envioRecomendacion.index');
//Rutas para Modulos Especiales
Route::get('/envioEncuesta', [ProfesorController::class, 'envioEncuesta'])->name('envioEncuesta.index');
Route::post('/asignarEncuesta', [ProfesorController::class, 'asignarEncuesta'])->name('asignarEncuesta');




//Rutas para Modulos Especiales
Route::post('/materialAsignacionProfesor', [ProfesorController::class, 'asignarMaterial'])->name('asignarMaterial.index');

//Ruta para la vista del foro
Route::get('/profesor/foro', [ForoController::class, 'profesorForo'])->name('profesor.foro');
Route::delete('/foro/publicacion/{id}', [ForoController::class, 'eliminarPublicacion'])->name('foro.eliminarPublicacion');
Route::delete('/foro/comentario/{id}', [ForoController::class, 'eliminarComentario'])->name('foro.eliminarComentario');


});


//Recursos para el alumno
Route::middleware(['auth', 'alumno'])->group(function () {

Route::get('/alumno/inicio', [AlumnoController::class, 'alumnoInicio'])->name('alumno.inicio');
Route::get('/alumno/eval', [AlumnoController::class, 'alumnoEvaluacion'])->name('alumno.detalleEvaluacion');
Route::get('/usuarioAlumno/inicio', [AlumnoController::class, 'alumnoInicio'])->name('usuarios.alumnoInicio');


//Ruta para la vista del foro
Route::get('/alumno/foro', [ForoController::class, 'alumnoForo'])->name('alumno.foro');
Route::get('/notificaciones', [AlumnoController::class, 'obtenerNotificaciones'])->name('notificaciones.obtener');



Route::post('/crear-publicacion', [ForoController::class, 'crearPublicacion'])->name('crearPublicacion');
Route::post('/agregar-comentario/{idPublicacionForo}', [ForoController::class, 'agregarComentario'])->name('agregarComentario');



//Recursos para el alumno
Route::get('/alumno/inicioCuestionario', [AlumnoController::class, 'alumnoCuestionario'])->name('alumnoCuestionario.inicio');
//Route::get('/alumno/mostrarCuestionario/{cuestionario}/mostrar', [AlumnoController::class, 'mostrarCuestionario'])->name('mostrarCuestionario');
Route::get('/cuestionario/{idCuestionario}/{idCuestionarioAlumno}', [AlumnoController::class, 'mostrarCuestionario'])->name('mostrarCuestionario');


Route::post('/cuestionarioAlumno', [AlumnoController::class, 'guardarRespuestas'])->name('guardarRespuestas');




//Encuestas para el alumno
Route::get('/alumno/inicioEncuesta', [AlumnoController::class, 'alumnoEncuesta'])->name('alumnoEncuesta.inicio');
Route::get('/encuesta/{idEncuesta}/{idEncuestaAlumno}', [AlumnoController::class, 'mostrarEncuesta'])->name('mostrarEncuesta');
Route::post('/encuestaAlumno', [AlumnoController::class, 'guardarRespuestasEncuesta'])->name('guardarRespuestasEncuesta');


//Ejercicios para el alumno 
Route::get('/alumno/inicioEjercicio', [AlumnoController::class, 'alumnoEjercicio'])->name('alumnoEjercicio.inicio');
Route::get('/alumno/{idEjercicio}', [AlumnoController::class, 'detalleEjercicio'])->name('ejercicioDetalle.inicio');


//Pasatiempos para el alumno
Route::get('/pasatiempoAlumno/inicioPasatiempo', [PasatiemposController::class, 'alumnoPasatiempo'])->name('alumnoPasatiempo.inicio');
Route::get('/pasatiempoAlumno/{idPasatiempo}', [PasatiemposController::class, 'detallePasatiempo'])->name('pasatiempoDetalle.inicio');



});



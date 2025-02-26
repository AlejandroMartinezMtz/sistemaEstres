<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RespaldoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Función para mostrar la vista principal del modulo de respaldos
    public function index()
    {
        return view('respaldos.index');
    }


    //Función para el respaldo de la base de datos del sistema
    public function respaldo()
    {
        $filename = 'backup_' . date('YmdHis') . '.sql';
        $path = storage_path('app/backups/' . $filename);

        if (!file_exists(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }

        $command = sprintf(
            '"C:\\xampp\\mysql\\bin\\mysqldump.exe" --user=%s --password=%s --host=%s %s > %s',
            escapeshellarg(env('DB_USERNAME')),
            escapeshellarg(env('DB_PASSWORD')),
            escapeshellarg(env('DB_HOST')),
            escapeshellarg(env('DB_DATABASE')),
            escapeshellarg($path),
            escapeshellarg(storage_path('app/backups/error_log.txt'))
        );
        
        $output = null;
        $returnVar = null;
        exec($command, $output, $returnVar);

        // Verifica si el archivo se creó correctamente
        if ($returnVar === 0 && file_exists($path)) {
            return redirect()->back()->with('success', 'Respaldo creado exitosamente: ' . $filename);
        } else {
            return redirect()->back()->with('error', 'Error al crear el respaldo. Verifica la configuración.');
        }
    }



    // Función para la restauración de la base de datos del sistema
    public function restaurar(Request $request)
    {
        // Obtener el archivo subido
        $file = $request->file('backup_file');
    
        // Guardar el archivo en la ubicación 
        $filename = $file->getClientOriginalName();
        $path = storage_path('app/backups/' . $filename);
        $file->move(storage_path('app/backups'), $filename);

        // Verifica si el archivo de respaldo existe
        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'El archivo de respaldo no existe.');
        }

        // Comando para restaurar la base de datos
        $command = sprintf(
            '"C:\\xampp\\mysql\\bin\\mysql.exe" --user=%s --password=%s --host=%s %s < %s',
            escapeshellarg(env('DB_USERNAME')),
            escapeshellarg(env('DB_PASSWORD')),
            escapeshellarg(env('DB_HOST')),
            escapeshellarg(env('DB_DATABASE')),
            escapeshellarg($path),
            escapeshellarg(storage_path('app/backups/error_restauracion.txt'))
        );

        $output = null;
        $returnVar = null;
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            \Log::error('Error en la restauración: ', $output);
        }

        // Verificar si el proceso de restauración fue exitoso
        if ($returnVar === 0) {
            return redirect()->back()->with('success', 'Restauración completada exitosamente desde: ' . $filename);
        } else {
         return redirect()->back()->with('error', 'Error al intentar restaurar la base de datos. Verifica la configuración.');
        }
    }


    //Función para validar la contraseña del usuario administrador antes de la restauración
    public function verificarPassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = Auth::user();

        if (Hash::check($request->password, auth()->user()->contrasenia)) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
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

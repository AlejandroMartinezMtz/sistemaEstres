<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Hash;  

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuario')->insert([
            'nombre' => 'Mateo',
            'apellidoP' => 'García',
            'apellidoM' => 'Hernández',
            'fechaNac' => '1999-03-17',
            'estadoActivo' => true,
            'correoPersonal' => 'mateo@gmail.com',
	    'correoInstitucional' => 'mateias12@gmail.com',
            'contrasenia' => Hash::make('mat1234'), // Encriptar contraseña
            'matricula' => 'HGMO21389',
            'codigoVerificacion' => '', 
            'fechaRegistro' => '2024-09-04',
            'fk_tipo_usuario' => 3,  // Asegúrate que este valor corresponda a un tipo de usuario válido
            'fk_programaEducativo' => 2,  // Asegúrate que este valor corresponda a un programa educativo válido
        ]);
    }
}

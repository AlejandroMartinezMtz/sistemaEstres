<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Hash;

class EncryptPasswords extends Command
{
    protected $signature = 'encrypt:passwords';
    protected $description = 'Encriptar las contraseñas de los usuarios existentes';

    public function handle()
    {
        // Recupera todos los usuarios
        $usuarios = Usuarios::all();

        foreach ($usuarios as $usuario) {
            // Encriptar la contraseña si no está encriptada
            if ($usuario->contrasenia && !Hash::needsRehash($usuario->contrasenia)) {
                // Encriptar la contraseña
                $usuario->contrasenia = Hash::make($usuario->contrasenia);
                // Guarda el usuario con la nueva contraseña encriptada
                $usuario->save();
                $this->info("Contraseña actualizada para el usuario: {$usuario->correo}");
            }
        }

        $this->info("Proceso de encriptación de contraseñas completado.");
    }
}

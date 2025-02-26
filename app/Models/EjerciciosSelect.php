<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EjerciciosSelect extends Model
{
    use HasFactory;


    protected $table = 'ejercicioSelec';

 
    public $timestamps = false;


    protected $primaryKey = 'idEjercicioSelec';

    // Especificar los campos que pueden ser llenados
    protected $fillable = ['idEjercicio', 'idUsuario', 'fechaSeleccion'];

    // Relación con Ejercicio
    public function ejercicio()
    {
        return $this->belongsTo(Ejercicios::class, 'idEjercicio', 'idEjercicio');
    }

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'idUsuario', 'idUsuario');
    }
}

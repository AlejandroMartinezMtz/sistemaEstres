<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ejercicios extends Model
{
    use HasFactory;

    protected $table = 'ejercicio';

    public $timestamps = false;

    protected $primaryKey = 'idEjercicio';

    // Especificar los campos que pueden ser llenados
    protected $fillable = ['nombre', 'descripcion', 'imagenUrl', 'videoUrl', 'tipo', 'nivelDificultad', 'duracionRecomendada', 'frecuenciaRecomendada', 'beneficios', 'fechaRegistro'];


    // Relación con ejercicioSelec
    public function ejerciciosSeleccionados()
    {
        return $this->hasMany(EjerciciosSelect::class, 'idEjercicio', 'idEjercicio');
    }

    // Relación con ejercicioAsignado
    public function ejerciciosAsignados()
    {
        return $this->hasMany(AsignacionesEjercicios::class, 'idEjercicio', 'idEjercicio');
    }

    

}

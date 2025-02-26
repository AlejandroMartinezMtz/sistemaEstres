<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasatiempos extends Model
{
    use HasFactory;

    protected $table = 'pasatiempo';

    public $timestamps = false;


    protected $primaryKey = 'idPasatiempo';

    // Especificar los campos que pueden ser llenados
    protected $fillable = ['nombre', 'descripcion', 'imagenUrl', 'videoUrl', 'tipo', 'requerimientos', 'duracionRecomendada', 'fechaRegistro'];


     // Establecer que cuando se cree un nuevo registro, se asigne la fecha actual a 'fechaRegistro'
     protected static function booted()
     {
         static::creating(function ($pasatiempo) {
             $pasatiempo->fechaRegistro = now();
         });
     }


    // Relación con pasatiempoSelec
    public function pasatiemposSeleccionados()
    {
        return $this->hasMany(PasatiemposSelect::class, 'idPasatiempo', 'idPasatiempo');
    }

    // Relación con ejercicioAsignado
    public function pasatiemposAsignados()
    {
        return $this->hasMany(AsignacionesPasatiempos::class, 'idPasatiempo', 'idPasatiempo');
    }
    
}

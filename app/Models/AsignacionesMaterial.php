<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionesMaterial extends Model
{
    use HasFactory;

    protected $table = 'asignacionMaterial';
    public $timestamps = false;
    protected $primaryKey = 'idMaterialA';
    protected $fillable = ['idUsuario_alumno', 'idUsuario_profesor', 'fechaRegistro'];


   // Relación con el alumno y el profesor
   public function alumno()
   {
       return $this->belongsTo(Usuarios::class, 'idUsuario_alumno', 'idUsuario');
   }

   public function profesor(){
       return $this->belongsTo(Usuarios::class, 'idUsuario_profesor', 'idUsuario');
   }

   public function ejercicio(){
       return $this->hasMany(AsignacionesEjercicios::class, 'idMaterial', 'idMaterialA'); 
   }

   public function pasatiempo(){
       return $this->hasMany(AsignacionesPasatiempos::class, 'idMaterial', 'idMaterialA');
   }


}

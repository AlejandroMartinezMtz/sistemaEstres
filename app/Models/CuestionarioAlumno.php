<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuestionarioAlumno extends Model
{
    use HasFactory;
    protected $table = 'cuestionarioAlumno';
    public $timestamps = false;
    protected $primaryKey = 'idCuestionarioAlumno';
    protected $fillable = ['fk_idCuestionario', 'fk_idAlumno', 'fechaAsignacion','estado'];

   // Relación con el cuestionario
   public function cuestionario()
   {
       return $this->belongsTo(Cuestionarios::class, 'fk_idCuestionario', 'idCuestionario');
   }

   // Relación con el alumno
   public function alumno()
   {
       return $this->belongsTo(Usuarios::class, 'fk_idAlumno', 'idUsuario');
   }


     // Establece que cuando se cree un nuevo registro, se asigne la fecha actual a 'fechaAsignacion'
     protected static function booted()
     {
         static::creating(function ($cuestionarioAlumno) {
            $cuestionarioAlumno->fechaAsignacion = now();
         });
     }

}

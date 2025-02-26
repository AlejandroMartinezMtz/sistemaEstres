<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumnosCreados extends Model
{
    use HasFactory;

     protected $table = 'alumnoCreado';

     public $timestamps = false;
 
     protected $primaryKey = 'idAlumCreado';
     
     // Si la clave primaria no es un número entero, usar
     // protected $keyType = 'string';
 
     // Especifica qué campos pueden ser llenados por asignación masiva
     protected $fillable = ['fk_idAlumnoC', 'fk_idProfesorCreador', 'fechaCreacion', 'fechaActualizacion'];


     // Establece que cuando se cree un nuevo registro, se asigne la fecha actual a 'fechaRegistro'
     protected static function booted()
     {
         static::creating(function ($alumnoCreado) {
             $alumnoCreado->fechaCreacion = now(); 
         });

         static::updating(function ($alumnoCreado) {
            $alumnoCreado->fechaActualizacion = now();
        });
     }


    // Relación con Usuario
    public function usuarioAlumno()
    {
        return $this->belongsTo(Usuarios::class, 'fk_idAlumnoC', 'idUsuario');
    }

    public function usuarioProfesor()
    {
        return $this->belongsTo(Usuarios::class, 'fk_idProfesorCreador', 'idUsuario');
    }


    
}

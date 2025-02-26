<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materias extends Model
{

    use HasFactory;
    protected $table = 'materia';

    public $timestamps = false;

    protected $primaryKey = 'idMateria';
    
    // Si la clave primaria no es un número entero, usar
    // protected $keyType = 'string';

    // Especificar los campos que pueden ser llenados
    protected $fillable = ['nombre', 'descripcion', 'horaSemana', 'cuatrimestre', 'numeroCreditos', 'fk_Programa', 'fechaCreacion'];


     // Establecer que cuando se cree un nuevo registro, se asigne la fecha actual a 'fechaCreacion'
     protected static function booted()
     {
         static::creating(function ($materia) {
             $materia->fechaCreacion= now(); // Inserta la fecha actual
         });
     }


    public function programaEducativo()
    {
        return $this->belongsTo(ProgramasEducativos::class, 'fk_Programa', 'idProgramaEducativo');
    }

    public function materiasSelec()
    {
        return $this->hasMany(MateriasSelect::class, 'fk_idMateria', 'idMateria');
    
    }
    

}

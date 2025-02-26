<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramasEducativos extends Model
{
    use HasFactory;

    protected $table = 'programaEducativo';
    public $timestamps = false;

    protected $primaryKey = 'idProgramaEducativo';

    protected $fillable = ['nombre', 'descripcion', 'nivel', 'duracion', 'facultad', 'fechaRegistro', 'estado'];

    
    // Establecer que cuando se cree un nuevo registro, se asigne la fecha actual a 'fechaRegistro'
    protected static function booted()
    {
        static::creating(function ($programa) {
            $programa->fechaRegistro = now();
            $programa->estado = 1;
        });
    }


    // Relación inversa con Usuario
    public function usuarios()
    {
        return $this->hasMany(Usuarios::class, 'fk_programaEducativo', 'idProgramaEducativo');

    }
   // Relación inversa con Materias
    public function materias()
    {
        return $this->hasMany(Materias::class, 'fk_Programa', 'idProgramaEducativo');
    }
    
}

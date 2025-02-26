<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriasSelect extends Model
{
    use HasFactory;

    protected $table = 'materiaSelec';

    public $timestamps = false;


    protected $primaryKey = 'idMateriaSelec';
    
    // Si la clave primaria no es un número entero, usar
    // protected $keyType = 'string';

    // Especificar los campos que pueden ser llenados
    protected $fillable = ['fk_idMateria', 'fk_idUsuario', 'fechaSeleccion'];



    public function materias()
    {
        return $this->belongsTo(Materias::class, 'fk_idMateria', 'idMateria');
    }

    // Relación con el alumno
    public function alumno()
   {
       return $this->belongsTo(Usuarios::class, 'fk_idUsuario', 'idUsuario');
   }

}

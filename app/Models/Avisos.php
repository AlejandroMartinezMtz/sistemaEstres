<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avisos extends Model
{
    use HasFactory;

    protected $table = 'aviso';


    public $timestamps = false;

    protected $primaryKey = 'idAviso';

  
    protected $fillable = ['titulo', 'descripcion', 'imagenUrl','fechaInicio', 'fechaFin', 'fechaCreacion','id_usuarioCreador'];

    // Establecer que cuando se cree un nuevo registro, se asigne la fecha actual a 'fechaRegistro'
    protected static function booted()
    {
        static::creating(function ($aviso) {
            $aviso->fechaCreacion = now();
        });
    }

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuarioCreador', 'idUsuario');
    }


}

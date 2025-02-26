<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelesSatisfaccion extends Model
{
    use HasFactory;
    protected $table = 'nivelSatisfaccion';
    public $timestamps = false;
    protected $primaryKey = 'idNivelSatisfaccion';
    protected $fillable = ['fk_encuestaContestada', 'fk_alumnoNivel', 'nivel' ,'fechaRegistro'];


    // Establecer que cuando se cree un nuevo registro, se asigne la fecha actual a 'fechaRegistro'
    protected static function booted()
    {
        static::creating(function ($nivelSatisfaccionModel) {
            $nivelSatisfaccionModel->fechaRegistro = now();
        });
    }

    // Relación con el alumno(usuario que respondio la encuesta)
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'fk_alumnoNivel', 'idUsuario');
    }

    // Relación con la encuesta
    public function encuesta()
    {
        return $this->belongsTo(Encuestas::class, 'fk_encuestaContestada', 'idencuesta');
    }



}

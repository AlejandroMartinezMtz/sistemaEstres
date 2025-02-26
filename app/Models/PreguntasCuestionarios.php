<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreguntasCuestionarios extends Model
{
    use HasFactory;
    protected $table = 'preguntaCuestionario';
    public $timestamps = false;
    protected $primaryKey = 'idPreguntaInstrumento';
    protected $fillable = ['textoPregunta', 'fk_idCuestionario'];

    // Relación con el cuestionario (una pregunta pertenece a un cuestionario)
    public function cuestionario()
    {
        return $this->belongsTo(Cuestionarios::class, 'fk_idCuestionario', 'idCuestionario');
    }

    // Relación con las respuestas (una pregunta tiene muchas respuestas)
    public function respuestas()
    {
        return $this->hasMany(RespuestasCuestionarios::class, 'fk_idPreguntaCuestionario', 'idPreguntaInstrumento');
    }



    
}

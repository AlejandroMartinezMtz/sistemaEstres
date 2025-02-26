<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionesEjercicios extends Model
{
    use HasFactory;


    protected $table = 'asignacionEjercicio';
    public $timestamps = false;
    protected $primaryKey = 'idAsignacionEjercicio';
    protected $fillable = ['idMaterial', 'idEjercicio'];



    //Relación con ejercicio
    public function ejercicio(){
        return $this->belongsTo(Ejercicios::class, 'idEjercicio', 'idEjercicio');
    }

    //Relación con material
    public function material(){
        return $this->belongsTo(AsignacionesMaterial::class, 'idMaterial', 'idMaterialA');
    }
    


}

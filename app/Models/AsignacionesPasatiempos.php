<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionesPasatiempos extends Model
{
    use HasFactory;


    protected $table = 'asignacionPasatiempo';
    public $timestamps = false;
    protected $primaryKey = 'idAsignacionPasatiempo';
    protected $fillable = ['idMaterial', 'idPasatiempo'];



    public function pasatiempo(){
        return $this->belongsTo(Pasatiempos::class, 'idPasatiempo', 'idPasatiempo');
    }

    public function material(){
        return $this->belongsTo(AsignacionesMaterial::class, 'idMaterial', 'idMaterialA');
    }
}

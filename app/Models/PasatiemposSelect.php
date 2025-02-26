<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasatiemposSelect extends Model
{
    use HasFactory;

    protected $table = 'pasatiempoSelec';

    public $timestamps = false;

    protected $primaryKey = 'idPasatiempoSelec';

    protected $fillable = ['idPasatiempo', 'idUsuario', 'fechaSeleccion'];


    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'idUsuario', 'idUsuario');
    }

    
    public function pasatiempo()
    {
        return $this->belongsTo(pasatiempos::class, 'idPasatiempo', 'idPasatiempo');
    }

}

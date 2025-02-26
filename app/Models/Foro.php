<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foro extends Model
{
    use HasFactory;

    protected $table = 'publicacionForo';

    public $timestamps = false;

    protected $primaryKey = 'idPublicacionForo';

    // Especificar los campos que pueden ser llenados
    protected $fillable = ['fk_idUsuario', 'texto', 'imagenUrl','fechaPublicacion'];


    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'fk_idUsuario', 'idUsuario');
    }

    public function comentario()
    {
        return $this->hasMany(ComentariosForo::class, 'fk_idPublicacionForo', 'idPublicacionForo');
    
    }
    
}

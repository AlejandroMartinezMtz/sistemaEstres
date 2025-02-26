<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentariosForo extends Model
{
    use HasFactory;

    protected $table = 'comentarioPublicacion';

    public $timestamps = false;

    protected $primaryKey = 'idComentarioPublicacion';

    protected $fillable = ['fk_idPublicacionForo', 'fk_idUsuario', 'comentario','fechaComentario'];


    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'fk_idUsuario', 'idUsuario');
    }

    public function publicacion()
    {
        return $this->belongsTo(Foro::class, 'fk_idPublicacionForo', 'idPublicacionForo');
    
    }


}

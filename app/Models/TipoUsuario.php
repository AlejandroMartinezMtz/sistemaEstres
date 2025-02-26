<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    use HasFactory;

    protected $table = 'tipo_usuario';
    protected $primaryKey = 'idTipo_usuario';

    protected $fillable = ['tipo']; 

    public function usuarios()
    {
        return $this->hasMany(Usuarios::class, 'fk_tipo_usuario', 'idTipo_usuario');
    }
}

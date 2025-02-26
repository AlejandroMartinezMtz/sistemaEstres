<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Usuarios extends Model implements Authenticatable
{
    use HasFactory;

     protected $table = 'usuario';

     public $timestamps = false;

     protected $primaryKey = 'idUsuario';
     
     // Si la clave primaria no es un número entero, usar
     // protected $keyType = 'string';
 
     // Especificar qué campos pueden ser llenados por asignación masiva
     protected $fillable = ['nombre', 'apellidoP', 'apellidoM', 'fechaNac', 'sexo',
        'estadoActivo', 'correoPersonal', 'correoInstitucional',
        'contrasenia', 'matricula', 'codigoVerificacion', 'fechaRegistro', 
        'fk_tipo_usuario', 'fk_programaEducativo'];


     // Establecer que cuando se cree un nuevo registro, se asigne la fecha actual a 'fechaRegistro'
     protected static function booted()
     {
         static::creating(function ($usuario) {
             $usuario->fechaRegistro = now();
             $usuario->contrasenia = Hash::make($usuario->contrasenia);//Encriptar la contraseña con hash
         });
     }



     // Métodos requeridos por la interfaz Authenticatable
    public function getAuthIdentifier()
    {
        return $this->getKey(); // Devuelve el ID del usuario
    }

    public function getAuthIdentifierName()
    {
        return 'idUsuario'; // El nombre del campo que se usa como identificador
    }

    public function getAuthPassword()
    {
        return $this->contrasenia; // Devuelve la contraseña almacenada
    }

    // Métodos para "remember me"
    public function getRememberToken()
    {
        return null; 
    }

    public function setRememberToken($value)
    {
        
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }




     // Relación con el modelo TipoUsuario
    public function tipoUsuario()
    {
        return $this->belongsTo(TipoUsuario::class, 'fk_tipo_usuario', 'idTipo_usuario');
    }

    public function programaEducativo()
    {
        return $this->belongsTo(ProgramasEducativos::class, 'fk_programaEducativo', 'idProgramaEducativo');
    }

    public function ejerciciosSeleccionados()
    {
        return $this->hasMany(EjerciciosSelect::class, 'idUsuario', 'idUsuario');
    }

    public function pasatiemposSeleccionados()
    {
        return $this->hasMany(PasatiemposSelect::class, 'idUsuario', 'idUsuario');
    }

    public function materiasSeleccionadas()
    {
        return $this->hasMany(MateriasSelect::class, 'fk_idUsuario', 'idUsuario');
    }




    public function alumnosCreados()
    {
        return $this->hasMany(AlumnosCreados::class, 'fk_idAlumnoC', 'idUsuario');
    }


    public function alumnosCreadosProfesor()
    {
    return $this->hasMany(AlumnosCreados::class, 'fk_idAlumnoC', 'idUsuario');
    }





    public function cuestionarios()
    {
        return $this->hasMany(Cuestionarios::class, 'fk_Autor', 'idUsuario');
    }

    // Relación con respuestas dadas por el usuario
    public function respuestas()
    {
        return $this->hasMany(RespuestasCuestionarios::class, 'fk_usuario', 'idUsuario');
    }


     // Relación con respuestas dadas por el usuario
     public function cuestionarioAlumno()
     {
         return $this->hasMany(CuestionarioAlumno::class, 'fk_idCuestionario', 'idUsuario');
     }


     public function asignacionAlumno()
     {
         return $this->hasMany(AsignacionesMaterial::class, 'idUsuario_alumno', 'idUsuario');
     }

     public function asignacionProfesor()
     {
         return $this->hasMany(AsignacionesMaterial::class, 'idUsuario_profesor', 'idUsuario');
     }

     public function evaluacion()
     {
         return $this->hasMany(EvaluacionEstres::class, 'fk_usuario', 'idUsuario');
     }

     public function nivel()
     {
         return $this->hasMany(NivelesSatisfaccion::class, 'fk_alumnoNivel', 'idUsuario');
     }


     public function encuestasAlumnos()
     {
         return $this->hasMany(EncuestasAlumnos::class, 'fk_idAlumnoE', 'idUsuario');
     }


     public function publicacionesAlumnos()
     {
         return $this->hasMany(Foro::class, 'fk_idUsuario', 'idUsuario');
     }

     public function comentariosAlumnos()
     {
         return $this->hasMany(ComentariosForo::class, 'fk_idUsuario', 'idUsuario');
     }


}

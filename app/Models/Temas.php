<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Temas extends BaseModel
{
    use SoftDeletes;
    
    protected $generarID = false;
    protected $guardarIDServidor = false;
    protected $guardarIDUsuario = false;
    public $incrementing = true;

    
    protected $table = 'tema';  
    protected $fillable = ["descripcion", 'id_ambito_riesgo'];

    public function usuarios(){
        return $this->belongsToMany('App\Models\Usuario', 'rol_usuario_tema', 'tema_id', 'usuario_id');
    }

    public function ambito()
    {
        return $this->belongsTo('\App\Models\AmbitoRiesgo', 'id_ambito_riesgo', "id");
    }
}

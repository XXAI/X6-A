<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelUsuarioTema extends BaseModel
{
    use SoftDeletes;
    
    protected $generarID = false;
    protected $guardarIDServidor = false;
    protected $guardarIDUsuario = false;
    public $incrementing = true;

    
    protected $table = 'rel_usuario_tema';  
    protected $fillable = ["usuario_id", "id_tema"];

    public function Tema(){
        return $this->hasOne('App\Models\Temas','id', 'id_tema');
    }

    public function usuarios(){
        return $this->belongsToMany('App\Models\Usuario', 'rol_usuario_tema', 'tema_id', 'usuario_id');
      }

}

<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Muestra extends BaseModel
{
    use SoftDeletes;
    
    protected $generarID = false;
    protected $guardarIDServidor = false;
    protected $guardarIDUsuario = true;
    public $incrementing = true;

    
    protected $table = 'muestra';  
    protected $fillable = ["mes", "id_jurisdiccion", "id_tema", "anio", "archivo","especificaciones", "folio", "id_verificacion"];

    public function jurisdiccion(){
        return $this->belongsTo('App\Models\Jurisdiccion', 'id_jurisdiccion');
    }

    public function tema(){
        return $this->belongsTo('App\Models\Temas', 'id_tema');
    }

    public function verificacion(){
        return $this->belongsTo('App\Models\Verificacion', 'id_verificacion');
    }
}

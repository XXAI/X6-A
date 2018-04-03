<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Dictamen extends BaseModel
{
    use SoftDeletes;
    
    protected $generarID = false;
    protected $guardarIDServidor = false;
    protected $guardarIDUsuario = true;
    public $incrementing = true;

    
    protected $table = 'dictamen';  
    protected $fillable = ["mes", "id_jurisdiccion", "id_tema", "anio", "archivo","oficio", "id_verificacion", "citatorios"];

    public function jurisdiccion(){
        return $this->belongsTo('App\Models\Jurisdiccion', 'id_jurisdiccion');
    }

    public function tema(){
        return $this->belongsTo('App\Models\Temas', 'id_tema');
    }

    public function verificacion(){
        return $this->belongsTo('App\Models\Verificacion', 'id_verificacion');
    }

    public function notificaciones(){
        return $this->HasMany('App\Models\DictamenArchivo', 'id_dictamen')->where("id_tipo_seguimiento", 1);
    }

    public function citatorios(){
        return $this->HasMany('App\Models\DictamenArchivo', 'id_dictamen')->where("id_tipo_seguimiento", 2);
    }

    public function resoluciones(){
        return $this->HasMany('App\Models\DictamenArchivo', 'id_dictamen')->where("id_tipo_seguimiento", 3);
    }

    public function amonestaciones(){
        return $this->HasMany('App\Models\DictamenArchivo', 'id_dictamen')->where("id_tipo_seguimiento", 4);
    }

    public function multas(){
        return $this->HasMany('App\Models\DictamenArchivo', 'id_dictamen')->where("id_tipo_seguimiento", 5);
    }
}

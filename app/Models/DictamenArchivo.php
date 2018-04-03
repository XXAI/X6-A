<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class DictamenArchivo extends BaseModel
{
    use SoftDeletes;
    
    protected $generarID = false;
    protected $guardarIDServidor = false;
    protected $guardarIDUsuario = true;
    public $incrementing = true;

    
    protected $table = 'dictamen_archivos';  
    protected $fillable = ["id_dictamen", "id_tipo_seguimiento", "oficio", "archivo"];

    public function jurisdiccion(){
        return $this->belongsTo('App\Models\Jurisdiccion', 'id_jurisdiccion');
    }
}

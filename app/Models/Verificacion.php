<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Verificacion extends BaseModel
{
    use SoftDeletes;
    
    protected $generarID = false;
    protected $guardarIDServidor = false;
    protected $guardarIDUsuario = true;
    public $incrementing = true;

    
    protected $table = 'verificacion';  
    protected $fillable = ["mes", "id_jurisdiccion", "id_tema", "anio", "archivo","folio", "folio_completo", "establecimiento", "giro", "medida_seguridad", "descripcion_medida", "informativa"];

    public function jurisdiccion(){
        return $this->belongsTo('App\Models\Jurisdiccion', 'id_jurisdiccion');
    }

    public function tema(){
        return $this->belongsTo('App\Models\Temas', 'id_tema');
    }
}

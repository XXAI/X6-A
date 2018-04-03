<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramacionTema extends BaseModel
{
    use SoftDeletes;
    
    protected $generarID = false;
    protected $guardarIDServidor = false;
    protected $guardarIDUsuario = false;
    public $incrementing = true;

    
    protected $table = 'programacion_jurisdiccion';  
    protected $fillable = ["id_jurisdiccion", "id_tema", "id_tipo_programacion", "anio", "enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre", "total"];

    public function jurisdiccion(){
        return $this->belongsTo('App\Models\Jurisdiccion', 'id_jurisdiccion');
    }
    
    public function tipo_programacion(){
        return $this->belongsTo('App\Models\TipoProgramacion', 'id_tipo_programacion');
    }

    public function tema(){
        return $this->belongsTo('App\Models\Temas', 'id_tema');
    }

}

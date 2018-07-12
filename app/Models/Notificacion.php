<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends BaseModel
{
    use SoftDeletes;
    
    protected $generarID = false;
    protected $guardarIDServidor = false;
    protected $guardarIDUsuario = true;
    public $incrementing = true;

    
    protected $table = 'registro_notificacion';  
    protected $fillable = ["no", "no_acta", "fecha_oficio_notificar", "id_area_operativa", "id_tipo_notificacion","id_procedimiento_notificacion", "establecimiento", "fecha_notificacion", "id_notificador", "fecha_entrega_responsble", "usuario_id"];

    public function areaOperativa(){
        return $this->belongsTo('App\Models\CatalogoAreaOperativa', 'id_area_operativa');
    }

    public function tipoDocumento(){
        return $this->belongsTo('App\Models\CatalogoTipoDocumento', 'id_tipo_notificacion')->where("id_documento", 4);
    }

    public function giro(){
        return $this->belongsTo('App\Models\CatalogoGiro', 'id_giro');
    }
}

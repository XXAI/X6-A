<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class DictamenTecnico extends Model
{
    use SoftDeletes;
    
    protected $generarID = false;
    protected $guardarIDServidor = false;
    protected $guardarIDUsuario = true;
    public $incrementing = true;

    
    protected $table = 'registro_dictamen';  
    protected $fillable = ["no", "no_acta", "id_area_operativa", "id_dictaminador","fecha_recepcion", "id_giro", "establecimiento", "id_tipo_dictamen", "fecha_dictamen", "id_resultado_lesp", "id_anomalias", "id_medida_seguridad", "no_notificacion", "fecha_emision", "fecha_entrega_notificar", "fecha_notificacion", "id_respuesta_usuario", "acta_seguimiento_numero", "id_estatus", "fecha_envio_resolucion", "usuario_id"];

    public function areaOperativa(){
        return $this->belongsTo('App\Models\CatalogoAreaOperativa', 'id_area_operativa');
    }

    public function tipoDocumento(){
        return $this->belongsTo('App\Models\CatalogoTipoDocumento', 'id_tipo_dictamen')->where("id_documento", 2);
    }

    public function giro(){
        return $this->belongsTo('App\Models\CatalogoGiro', 'id_giro');
    }
}

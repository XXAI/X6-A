<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Denuncia extends BaseModel
{
    use SoftDeletes;
    
    protected $generarID = false;
    protected $guardarIDServidor = false;
    protected $guardarIDUsuario = false;
    public $incrementing = true;

    
    protected $table = 'denuncia';  
    protected $fillable = ["codigo", "anonimo", "nombre",	"apellido_paterno",	"apellido_materno",	"sexo",	"edad",	"correo", "lada", "telefono", "ext", "cp_persona", "estado_persona", "municipio_persona", "localidad_persona", "colonia_persona", "calle_persona", "ext_persona", "int_persona", "tipo_denuncia", "razon_social", "giro", "producto", "estado_denuncia", "municipio_denuncia", "colonia_denuncia", "calle_denuncia", "ext_denuncia", "cp_denuncia", "narracion" ];

    public function catalogoEntidadPersona(){
        return $this->belongsTo('App\Models\CatalogoEntidad', 'estado_persona');
    }

    public function catalogoMunicipioPersona(){
        return $this->belongsTo('App\Models\CatalogoMunicipio', 'municipio_persona');
    }

    public function catalogoLocalidadPersona(){
        return $this->belongsTo('App\Models\CatalogoLocalidad', 'localidad_persona');
    }

    public function catalogoEntidadDenuncia(){
        return $this->belongsTo('App\Models\CatalogoEntidad', 'estado_denuncia');
    }

    public function catalogoMunicipioDenuncia(){
        return $this->belongsTo('App\Models\CatalogoMunicipio', 'municipio_denuncia');
    }

    public function seguimiento(){
        return $this->hasMany('App\Models\DenunciaSeguimiento', 'denuncia_id')->orderBy("created_at", "desc");
    }
}

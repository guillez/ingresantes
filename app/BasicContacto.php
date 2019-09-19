<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasicContacto extends Model
{
    protected $table = 'basiccontacto';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'telefonofijocar',
        'telefonofijonum',
        'celularcar',
        'celularnum',
        'fk_ciudad_id',
        'fk_planestudio_id',
        'consulta',
        'estado'
    ];
}

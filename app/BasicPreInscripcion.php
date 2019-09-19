<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasicPreInscripcion extends Model
{
    protected $table = 'basicpreinscripcion';

    protected $fillable = [
        'nombre',
        'apellido',
        'fechanacimiento',
        'dni',
        'email',
        'telefonofijocar',
        'telefonofijonum',
        'celularcar',
        'celularnum',
        'direccion',
        'fk_ciudad_id',
        'fk_planestudio_id',
        'fk_sede_id',
        'fk_estudioprevio_id',
        'perteneceucu',
        'estado'
    ];
}
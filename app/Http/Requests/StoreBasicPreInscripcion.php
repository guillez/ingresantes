<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBasicPreInscripcion extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //return auth()->user()->hasRole('administrator');
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'required',
            'apellido' => 'required',
            'fechanacimiento' => 'required',
            'dni' => 'required',
            'email' => 'required',
            'telefonofijonum' => 'required',
            'celularnum' => 'required',
            'direccion' => 'required',
            'fk_ciudad_id' => 'required',
            'fk_planestudio_id' =>  'required',
            'fk_sede_id' => 'required',
            'fk_estudioprevio_id' => 'required',
            'perteneceucu' => 'required'       
        ];
    }  

    public function messages()
    {
        return [
            'nombre.required' => 'El campo Nombre es obligatorio',
            'apellido.required' => 'El campo Apellido es obligatorio',
            'fechanacimiento.required' => 'El campo Fecha de nacimiento es obligatorio',
            'dni.required' => 'El campo Número de documento es obligatorio',
            'email.required' => 'El campo E-mail es obligatorio',
            'telefonofijonum.required' => 'El campo Teléfono es obligatorio',
            'celularnum.required' => 'El campo Celular es obligatorio',
            'direccion.required' => 'El campo Dirección es obligatorio',
            'fk_ciudad_id.required' => 'El campo Ciudad es obligatorio',
            'fk_planestudio_id.required' =>  'El campo Carrera de interés es obligatorio',
            'fk_sede_id.required' => 'El campo Sede de interés es obligatorio',
            'fk_estudioprevio_id.required' => 'El campo Estudios previos es obligatorio',
            'perteneceucu.required' => 'El campo ¿Pertenece a la comunidad UCU? es obligatorio',               
        ];
    }   
}

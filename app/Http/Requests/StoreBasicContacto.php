<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBasicContacto extends FormRequest
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
            'email' => 'required',
            'telefonofijonum' => 'required',
            'celularnum' => 'required',
            'fk_ciudad_id' => 'required',
            'fk_planestudio_id' =>  'required',
            'consulta' => 'required'       
        ];
    }  

    public function messages()
    {
        return [
            'nombre.required' => 'El campo Nombre es obligatorio',
            'apellido.required' => 'El campo Apellido es obligatorio',
            'email.required' => 'El campo E-mail es obligatorio',
            'telefonofijonum.required' => 'El campo Teléfono es obligatorio',
            'celularnum.required' => 'El campo Celular es obligatorio',
            'fk_ciudad_id.required' => 'El campo Ciudad es obligatorio',
            'fk_planestudio_id.required' =>  'El campo Carrera de interés es obligatorio',
            'consulta.required' => 'El campo Consulta es obligatorio',               
        ];
    }   
}

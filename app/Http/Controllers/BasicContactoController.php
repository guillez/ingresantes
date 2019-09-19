<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BasicContacto;
use DB;
use Mail;
use Datatables;
use App\Http\Requests\StoreBasicContacto;

class BasicContactoController extends Controller
{
    public function anyData()
    {
        $contacto = BasicContacto::where('estado', '=', 0);

        return Datatables::of($contacto)
            ->addColumn('nombre', function ($contacto) {
                return $contacto->nombre;
            })
            ->addColumn('apellido', function ($contacto) {
                return $contacto->apellido;
            })
            ->addColumn('consulta', function ($contacto) {
                return $contacto->consulta;
            })            
            ->addColumn('carrera', function ($contacto) {
    			$carrera = DB::connection('alumnos')->table('carreras')->join('planes_estudios', 'carreras.idcarrera', '=', 'planes_estudios.idcarrera')->where('planes_estudios.idplanestudio' , '=', $contacto->fk_planestudio_id)->select('carreras.nombre')->first();	

                return $carrera->nombre;
            })                                   
            ->addColumn('action', function ($contacto) {
                $acciones = '<a title="Editar" href="contacto/'.$contacto->id.'/edit" class="btn btn-primary"><span title="Editar" class="far fa-edit"></span></a> ';          

                $acciones .= '<a title="Ver" href="contacto/'.$contacto->id.'" class="btn btn-primary"><span title="Ver" class="far fa-eye"></span></a>'; 
                return $acciones;         
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function index()
    {
        return view('contacto.index');
    }


    public function store(StoreBasicContacto $request)
    {
    	$request['telefonofijocar'] = is_null($request['telefonofijocar']) ? 0 : 1;
    	$request['celularcar'] = is_null($request['celularcar']) ? 0 : 1;
		$contacto = BasicContacto::create($request->all());

    	$carrera = DB::connection('alumnos')->table('carreras')->join('planes_estudios', 'carreras.idcarrera', '=', 'planes_estudios.idcarrera')->where('planes_estudios.idplanestudio' , '=', $request['fk_planestudio_id'])->select('carreras.nombre')->first();
		$nombrecarrera = $carrera->nombre;

    	$ciudad = DB::connection('alumnos')->table('ciudades')->where('idciudad' , '=', $request['fk_ciudad_id'])->first();
		$nombreciudad = $ciudad->descripcion;
		$my_destination = array('udrizardm@gmail.com', 'informatica@ucu.edu.ar');

        Mail::send('emails.contacto', ['contacto' => $contacto, 'carrera' => $nombrecarrera, 'ciudad' => $nombreciudad], function ($message) use ($my_destination)
                {
                    $message->from('tramitesalumnos@ucu.edu.ar', 'AELF-UCU: Sistema Alumnos');
                    $message->to($my_destination);
                    $message->subject('AELF-UCU: Contacto');
                }
            );

		return redirect()
			->route('contacto.form')->with('success', 'Su Consulta se ha enviado correctamente!');       
    }

    public function contactar()
    {
    	$carreras = DB::connection('alumnos')->table('carreras')
	    	->join('planes_estudios', 'carreras.idcarrera', '=', 'planes_estudios.idcarrera')
	    	->join('carreras_sede', 'carreras.idcarrera', '=', 'carreras_sede.idcarrera')
			->where('planes_estudios.idestadoplan' , '=', 2)
			->where('carreras.idestadocarrera' , '=', 1)
			->whereNotIn('carreras.idtipocarrera', [0, 1, 2, 5, 6, 7])
			->orderBy('carreras.nombre', 'ASC')
			->groupBy('carreras.idcarrera')
			->pluck('carreras.nombre', 'planes_estudios.idplanestudio');

    	$paises = DB::connection('alumnos')->table('paises')
	    	->orderBy('descripcion', 'ASC')
			->pluck('descripcion', 'idpais');

		$provincias = array('0' => 'SELECCIONA');	
		$ciudades = array('0' => 'SELECCIONA');			

		return view('contacto.form', compact('carreras', 'paises', 'provincias', 'ciudades'));
    }

    public function destroy($id)
    {
        if (BasicContacto::destroy($id)) {
            return redirect('/contacto')
                ->with('success', 'Registro eliminado exitosamente!');
        } else {
            return redirect('/contacto')
                ->withErrors('No se ha podido eliminar el registro!'); 
        }      
    }       

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $contacto = BasicContacto::findOrFail($id);

        $carreras = DB::connection('alumnos')->table('carreras')
            ->join('planes_estudios', 'carreras.idcarrera', '=', 'planes_estudios.idcarrera')
            ->join('carreras_sede', 'carreras.idcarrera', '=', 'carreras_sede.idcarrera')
            ->where('planes_estudios.idestadoplan' , '=', 2)
            ->where('carreras.idestadocarrera' , '=', 1)
            ->whereNotIn('carreras.idtipocarrera', [0, 1, 2, 5, 6, 7])
            ->orderBy('carreras.nombre', 'ASC')
            ->groupBy('carreras.idcarrera')
            ->pluck('carreras.nombre', 'planes_estudios.idplanestudio');

        $paises = DB::connection('alumnos')->table('paises')
            ->orderBy('descripcion', 'ASC')
            ->pluck('descripcion', 'idpais');

        $provincias = array('0' => 'SELECCIONA');   
        $ciudades = array('0' => 'SELECCIONA');         
        $estudiosprevios = array('1' => 'Secundario incompleto', '2' => 'Secundario completo', '3' => 'Terciario incompleto', '4' => 'Terciario completo', '5' => 'Universitario incompleto', '6' => 'Universitario completo', '7' => 'Especialización/Maestría/Doctorado' );
        $perteneceucu = array('0' => 'Si', '1' => 'No');
        $sedes = array('0' => 'SELECCIONA');        

        return view('contacto.edit', compact('contacto', 'carreras', 'estudiosprevios', 'perteneceucu', 'sedes', 'paises', 'provincias', 'ciudades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, StoreBasicContacto $request)
    {
        $record = BasicContacto::findOrFail($id);
        $record->fill($request->all())->save();

        return redirect('/contacto')
            ->with('success', 'Registro modificado exitosamente!');
    }

    /**
     * Show the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $contacto = BasicContacto::findOrFail($id);

        $ciudad = DB::connection('alumnos')->table('ciudades')->where('idciudad' , '=', $contacto->fk_ciudad_id)->first();
        $nombreciudad = $ciudad->descripcion;

        $carrera = DB::connection('alumnos')->table('carreras')
            ->join('planes_estudios', 'carreras.idcarrera', '=', 'planes_estudios.idcarrera')
            ->where('planes_estudios.idplanestudio' , '=', $contacto->fk_planestudio_id)
            ->pluck('carreras.nombre');
        $nombrecarrera = $carrera[0];

        return view('contacto.show', ['contacto' => $contacto, 'ciudad' => $nombreciudad, 'carrera' => $nombrecarrera]);
    }      
}

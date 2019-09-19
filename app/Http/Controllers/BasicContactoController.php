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
        $contacto = BasicContacto::select(['id', 'nombre', 'apellido'])->where('estado', '=', 0);


        return Datatables::of($contacto)
            ->addColumn('nombre', function ($contacto) {
                return $contacto->nombre;
            })
            ->addColumn('apellido', function ($contacto) {
                return $contacto->apellido;
            })
            ->addColumn('carrera', function ($contacto) {
    			$carrera = DB::connection('alumnos')->table('carreras')->join('planes_estudios', 'carreras.idcarrera', '=', 'planes_estudios.idcarrera')->where('planes_estudios.idplanestudio' , '=', $contacto->fk_planestudio_id)->select('carreras.nombre')->first();	

                return $carrera->nombre;
            })    
        	->addColumn('sede', function ($contacto) {
    			$sede = DB::connection('alumnos')->table('sedes')->where('idsede' , '=', $request['fk_sede_id'])->first();
		
                return $sede->nombre;
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
}

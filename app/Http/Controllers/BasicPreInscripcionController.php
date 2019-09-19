<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BasicPreInscripcion;
use DB;
use Mail;
use Datatables;
use App\Http\Requests\StoreBasicPreInscripcion;

class BasicPreInscripcionController extends Controller
{
    public function anyData()
    {
        $pre = BasicPreInscripcion::select(['id', 'nombre', 'apellido', 'fechanacimiento', 'dni'])->where('estado', '=', 0);

        return Datatables::of($pre)
            ->addColumn('nombre', function ($pre) {
                return $pre->nombre;
            })
            ->addColumn('apellido', function ($pre) {
                return $pre->apellido;
            })
            ->addColumn('fechanacimiento', function ($pre) {
                return date("d-m-Y", strtotime($pre->fechanacimiento));
            })
            ->addColumn('dni', function ($pre) {
                return $pre->dni;
            })                            
            ->addColumn('action', function ($pre) {
                $acciones = '<a title="Editar" href="preinscripcion/'.$pre->id.'/edit" class="btn btn-primary"><span title="Editar" class="far fa-edit"></span></a> ';          

                $acciones .= '<a title="Ver" href="preinscripcion/'.$pre->id.'" class="btn btn-primary"><span title="Ver" class="far fa-eye"></span></a>'; 
                return $acciones;         
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function index()
    {
        return view('preinscripcion.index');
    }

    public function store(StoreBasicPreInscripcion $request)
    {
		$estudiosprevios = array('1' => 'Secundario incompleto', '2' => 'Secundario completo', '3' => 'Terciario incompleto', '4' => 'Terciario completo', '5' => 'Universitario incompleto', '6' => 'Universitario completo', '7' => 'Especialización/Maestría/Doctorado' );
		$perteneceucu = array('0' => 'Si', '1' => 'No');

    	$request['fechanacimiento'] = implode('-', array_reverse(explode('-', $request['fechanacimiento'])));
    	$request['telefonofijocar'] = is_null($request['telefonofijocar']) ? 0 : 1;
    	$request['celularcar'] = is_null($request['celularcar']) ? 0 : 1;
		$pre = BasicPreInscripcion::create($request->all());

    	$carrera = DB::connection('alumnos')->table('carreras')->join('planes_estudios', 'carreras.idcarrera', '=', 'planes_estudios.idcarrera')->where('planes_estudios.idplanestudio' , '=', $request['fk_planestudio_id'])->select('carreras.nombre')->first();
		$nombrecarrera = $carrera->nombre;

    	$ciudad = DB::connection('alumnos')->table('ciudades')->where('idciudad' , '=', $request['fk_ciudad_id'])->first();
		$nombreciudad = $ciudad->descripcion;

    	$sede = DB::connection('alumnos')->table('sedes')->where('idsede' , '=', $request['fk_sede_id'])->first();
		$nombresede = $sede->nombre;
		
        Mail::send('emails.preinscripcion', ['pre' => $pre, 'carrera' => $nombrecarrera, 'ciudad' => $nombreciudad, 'estudioprevio' =>$estudiosprevios[$request['fk_estudioprevio_id']], 'perteneceucu' => $perteneceucu[$request['perteneceucu']], 'sede' => $nombresede], function ($message)
                {
                	$my_destination = array('udrizardm@gmail.com', 'informatica@ucu.edu.ar');

                    $message->from('tramitesalumnos@ucu.edu.ar', 'AELF-UCU: Sistema Alumnos');
                    $message->to($my_destination);
                    $message->subject('AELF-UCU: PreInscripción');
                }
            );

		return redirect()
			->route('preinscripcion.form')->with('success', 'Su PreInscripción se ha realizado correctamente!');       
    }

    public function preinscribir()
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
		$estudiosprevios = array('1' => 'Secundario incompleto', '2' => 'Secundario completo', '3' => 'Terciario incompleto', '4' => 'Terciario completo', '5' => 'Universitario incompleto', '6' => 'Universitario completo', '7' => 'Especialización/Maestría/Doctorado' );
		$perteneceucu = array('0' => 'Si', '1' => 'No');
		$sedes = array('0' => 'SELECCIONA');		

		return view('preinscripcion.form', compact('carreras', 'estudiosprevios', 'perteneceucu', 'sedes', 'paises', 'provincias', 'ciudades'));
    } 

    public function destroy($id)
    {
        if (BasicPreInscripcion::destroy($id)) {
            return redirect('/preinscripcion')
                ->with('success', 'Registro eliminado exitosamente!');
        } else {
            return redirect('/preinscripcion')
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
        $preinscripcion = BasicPreInscripcion::findOrFail($id);

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

        return view('preinscripcion.edit', compact('preinscripcion', 'carreras', 'estudiosprevios', 'perteneceucu', 'sedes', 'paises', 'provincias', 'ciudades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, StoreBasicPreInscripcion $request)
    {
        $request['fechanacimiento'] = date('Y-m-d', strtotime($request['fechanacimiento']));

        $record = BasicPreInscripcion::findOrFail($id);
        $record->fill($request->all())->save();

        return redirect('/preinscripcion')
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
        $preinscripcion = BasicPreInscripcion::findOrFail($id);

        $ciudad = DB::connection('alumnos')->table('ciudades')->where('idciudad' , '=', $preinscripcion->fk_ciudad_id)->first();
        $nombreciudad = $ciudad->descripcion;

        $carrera = DB::connection('alumnos')->table('carreras')
            ->join('planes_estudios', 'carreras.idcarrera', '=', 'planes_estudios.idcarrera')
            ->where('planes_estudios.idplanestudio' , '=', $preinscripcion->fk_planestudio_id)
            ->pluck('carreras.nombre');
        $nombrecarrera = $carrera[0];

        $sede = DB::connection('alumnos')->table('sedes')->where('idsede' , '=', $preinscripcion->fk_sede_id)->first();
        $nombresede = $sede->nombre;

        $estudiosprevios = array('1' => 'Secundario incompleto', '2' => 'Secundario completo', '3' => 'Terciario incompleto', '4' => 'Terciario completo', '5' => 'Universitario incompleto', '6' => 'Universitario completo', '7' => 'Especialización/Maestría/Doctorado' );
        $perteneceucu = array('0' => 'Si', '1' => 'No');

        return view('preinscripcion.show', ['preinscripcion' => $preinscripcion, 'ciudad' => $nombreciudad, 'perteneceucu' => $perteneceucu[$preinscripcion->perteneceucu], 'estudiosprevios' => $estudiosprevios[$preinscripcion->fk_estudioprevio_id], 'carrera' => $nombrecarrera, 'sede' => $nombresede]);
    }  

    public function getSedes(Request $request, $id){
        if($request->ajax()){
            $sedes = DB::connection('alumnos')->table('sedes')
                ->join('carreras_sede', 'sedes.idsede', '=', 'carreras_sede.idsede')
                ->join('planes_estudios', 'carreras_sede.idcarrera', '=', 'planes_estudios.idcarrera')
                ->where('planes_estudios.idplanestudio' , '=', $id)
                ->orderBy('sedes.idsede', 'ASC')
                ->select('sedes.*')
                ->get();

            return response()->json($sedes);
        }
    }       

    public function getProvincias(Request $request, $id){
        if($request->ajax()){
    		$provincias = DB::connection('alumnos')->table('provincias')
				->where('idpais' , '=', $id)
				->orderBy('descripcion', 'ASC')
				->get();

            return response()->json($provincias);
        }
    }     

    public function getCiudades(Request $request, $id){
        if($request->ajax()){
    		$ciudades = DB::connection('alumnos')->table('ciudades')
				->where('idprovincia' , '=', $id)
				->where('descripcion', '<>', '')
				->orderBy('descripcion', 'ASC')
				->get();

            return response()->json($ciudades);
        }
    }             
}

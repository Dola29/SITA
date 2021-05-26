<?php

namespace App\Http\Controllers;

use App\Trabajo;
use App\TrabajoAsesor;
use App\TrabajoSustentante;
use Illuminate\Http\Request;

class TrabajoController extends Controller
{
    public function index(Request $request)
    {
        $data_search = array();

        if ($request['search']) {
            $data_search['0' ] = ['tema', 'like', '%' . $request['search'] . '%'];
        }
        
        if ($request['facultad_id'] > 0) {
            $data_search['facultad_id' ] = $request['facultad_id'];
        }

        if ($request['escuela_id'] > 0) {
            $data_search['escuela_id' ] = $request['escuela_id'];
        }

        if ($request['carrera_id'] > 0) {
            $data_search['carrera_id' ] = $request['carrera_id'];
        }

        if ($request['recinto_id'] > 0) {
            $data_search['recinto_id' ] = $request['recinto_id'];
        }
        if ($request['ubicacion_id'] > 0) {

            $data_search['ubicacion_id' ] = $request['ubicacion_id'];
        }
       // print_r($data_search);
        if($request['parametro']){
            return Trabajo::with('facultad')->with('escuela')->with('carrera')
                            ->with('recinto')->with('ubicacion')
                            ->with('sustentantes.sustentante')->with('asesores.asesor')
                            ->where($data_search)
                            ->get();
        }else{
            return Trabajo::with('facultad')->with('escuela')->with('carrera')
                            ->with('recinto')->with('ubicacion')
                            ->with('sustentantes.sustentante')->with('asesores.asesor')->get();
        }  
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'tema' => 'required|string|max:191|unique:trabajos',
            'facultad_id'=>'required',
            'escuela_id'=>'required',
            'carrera_id'=>'required',
            'recinto_id'=>'required',
            'ubicacion_id'=>'required',
            'fecha_inicio'=>'required',
            'fecha_fin'=>'required',
            'tipo_trabajo'=>'required',
            'nivel'=>'required',
            'titulo' => 'required|string',
        ]);

        return Trabajo::create([           
            'tema' => $request['tema'],
            'facultad_id' => $request['facultad_id'],
            'escuela_id' => $request['escuela_id'],
            'carrera_id' => $request['carrera_id'],
            'recinto_id' => $request['recinto_id'],
            'ubicacion_id' => $request['ubicacion_id'],
            'fecha_inicio' => $request['fecha_inicio'],
            'fecha_fin' => $request['fecha_fin'],
            'tipo_trabajo' => $request['tipo_trabajo'],
            'nivel' => $request['nivel'],
            'titulo' => $request['titulo'],
            'key_id' => generate_key(),
        ]);
    }

    public function update(Request $request, $key_id)
    {
        $trabajo = Trabajo::where('key_id','=', $key_id)->firstOrFail();
        
        $this->validate($request,[
            'tema' => 'required|string|max:191',
            'facultad_id'=>'required',
            'escuela_id'=>'required',
            'carrera_id'=>'required',
            'recinto_id'=>'required',
            'ubicacion_id'=>'required',
            'fecha_inicio'=>'required',
            'fecha_fin'=>'required',
            'tipo_trabajo'=>'required',
            'nivel'=>'required',
            'titulo' => 'required|string',
        ]);

        $data = array(
            'tema' => $request['tema'],
            'facultad_id' => $request['facultad_id'],
            'escuela_id' => $request['escuela_id'],
            'carrera_id' => $request['carrera_id'],
            'recinto_id' => $request['recinto_id'],
            'ubicacion_id' => $request['ubicacion_id'],
            'fecha_inicio' => $request['fecha_inicio'],
            'fecha_fin' => $request['fecha_fin'],
            'tipo_trabajo' => $request['tipo_trabajo'],
            'nivel' => $request['nivel'],
            'titulo' => $request['titulo'],
            'updated_at' => time_s_now()
        );
        
        $trabajo->update($data);
        
        return ['message' => 'Trabajo Actualizado'];
    }

    public function getSustentantes($trabajo_id){
        return TrabajoSustentante::with('sustentante')->where('trabajo_id', $trabajo_id)->get();
    }

    public function getAsesores($trabajo_id){
        return TrabajoAsesor::with('asesor')->where('trabajo_id', $trabajo_id)->get();
    }

    public function insertSustentante(Request $request){
        return TrabajoSustentante::create([  
            'trabajo_id' => $request['trabajo_id'],
            'sustentante_id' => $request['sustentante_id'],
            'key_id' => generate_key(),
        ]);
    }

    public function insertAsesor(Request $request){
        return TrabajoAsesor::create([  
            'trabajo_id' => $request['trabajo_id'],
            'asesor_id' => $request['asesor_id'],
            'key_id' => generate_key(),
        ]);
    }

    public function destroySustentante($key_id)
    {
        $sustentante = TrabajoSustentante::where('key_id','=', $key_id)->firstOrFail();
        $sustentante->delete();
        return ['message' => 'Sustentante eliminado!'];
    }

    public function destroyAsesor($key_id)
    {
        $asesor = TrabajoAsesor::where('key_id','=', $key_id)->firstOrFail();
        $asesor->delete();
        return ['message' => 'Asesor eliminado!'];
    }

    public function destroy($key_id)
    {
        $trabajo = Trabajo::where('key_id','=', $key_id)->firstOrFail();
        $trabajo->delete();
        return ['message' => 'Trabajo eliminado!'];
    }
}

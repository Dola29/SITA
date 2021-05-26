<?php

namespace App\Http\Controllers;

use App\Carrera;
use Illuminate\Http\Request;
use App\Http\Resources\Carrera as RCarrera;

class CarreraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request['search'] === null) {
            return Carrera::with('facultad')->with('escuela')->get();
        }   
        
        if ($request['search']) {
            return Carrera::with('facultad')->with('escuela')
                                ->where('nombre', 'like', '%' . $request['search'] . '%')->get();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'nombre' => 'required|string|max:191|unique:carreras',
            'facultad_id'=>'required',
            'escuela_id'=>'required',
            'titulo' => 'required|string',
            'activo' => 'string|max:2',
        ]);

        return Carrera::create([           
            'nombre' => $request['nombre'],
            'facultad_id' => $request['facultad_id'],
            'escuela_id' => $request['escuela_id'],
            'titulo' => $request['titulo'],
            'activo' => $request['activo'],
            'key_id' => generate_key(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $key_id)
    {
        $carrera = Carrera::where('key_id','=', $key_id)->firstOrFail();
        
        $this->validate($request,[
            'nombre' => 'required|string|max:191',
            'facultad_id'=>'required',
            'escuela_id'=>'required',
            'titulo' => 'required|string',
            'activo' => 'required|string|max:2',
        ]);

        $data = array(
            'nombre' => $request['nombre'],
            'facultad_id' => $request['facultad_id'],
            'escuela_id' => $request['escuela_id'],
            'titulo' => $request['titulo'],
            'activo' => $request['activo'],        
            'updated_at' => time_s_now()
        );
        
        $carrera->update($data);
        
        return ['message' => 'Carrera Actualizada'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Carrera  $carrera
     * @return \Illuminate\Http\Response
     */
    public function destroy($key_id)
    {
        $carrera = Carrera::where('key_id','=', $key_id)->firstOrFail();
        $carrera->delete();
        return ['message' => 'Carrera eliminada!'];
    }

    public function getList($escuela_id)
    {
        if($escuela_id == 0){
            return RCarrera::collection(Carrera::where('activo', '=', 'si')->get());
        }
        return RCarrera::collection(Carrera::where('activo', '=', 'si')->where('escuela_id', $escuela_id)->get());
    }
}

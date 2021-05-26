<?php

namespace App\Http\Controllers;

use App\Ubicacion;
use Illuminate\Http\Request;
use App\Http\Resources\Ubicacion as RUbicacion;

class UbicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request['search'] === null) {
            return Ubicacion::all();
        }   
        
        if ($request['search']) {
            $query =  Ubicacion::where('nombre', 'like', '%' . $request['search'] . '%')->get();
            return $query;
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
            'nombre' => 'required|string|max:191|unique:ubicaciones',
            'descripcion' => 'string',
            'activo' => 'string|max:2',
        ]);

        return Ubicacion::create([           
            'nombre' => $request['nombre'],
            'descripcion' => $request['descripcion'],
            'activo' => $request['activo'],
            'key_id' => generate_key(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ubicacion  $ubicacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $key_id)
    {
        $ubicacion = Ubicacion::where('key_id','=', $key_id)->firstOrFail();
        
        $this->validate($request,[
            'nombre' => 'required|string|max:191',
            'descripcion' => 'string',
            'activo' => 'required|string|max:2',
        ]);

        $data = array(
            'nombre' => $request['nombre'],
            'descripcion' => $request['descripcion'],
            'activo' => $request['activo'],        
            'updated_at' => time_s_now()
        );
        
        $ubicacion->update($data);
        
        return ['message' => 'Ubicacion Actualizada'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ubicacion  $ubicacion
     * @return \Illuminate\Http\Response
     */
    public function destroy($key_id)
    {
        $ubicacion = Ubicacion::where('key_id','=', $key_id)->firstOrFail();
        $ubicacion->delete();
        return ['message' => 'Ubicacion eliminada!'];
    }

    public function getList()
    {
        return RUbicacion::collection(Ubicacion::where('activo', '=', 'si')->get());
    }
}

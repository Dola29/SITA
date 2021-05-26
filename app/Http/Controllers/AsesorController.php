<?php

namespace App\Http\Controllers;

use App\Asesor;
use Illuminate\Http\Request;
use App\Http\Resources\Asesor as RAsesor;

class AsesorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request['search'] === null) {
            return Asesor::all();
        }   
        
        if ($request['search']) {
            $query =  Asesor::where('nombre', 'like', '%' . $request['search'] . '%')->get();
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
            'nombre' => 'required|string|max:191|unique:Asesores',
            'telefono' => 'string',
            'correo' => 'string',
            'activo' => 'string|max:2',
        ]);

        return Asesor::create([           
            'nombre' => $request['nombre'],
            'telefono' => $request['telefono'],
            'correo' => $request['correo'],
            'activo' => $request['activo'],
            'key_id' => generate_key(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Asesor  $asesor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $key_id)
    {
        $asesor = Asesor::where('key_id','=', $key_id)->firstOrFail();
        
        $this->validate($request,[
            'nombre' => 'required|string|max:191',
            'telefono' => 'string',
            'correo' => 'string',
            'activo' => 'required|string|max:2',
        ]);

        $data = array(
            'nombre' => $request['nombre'],
            'telefono' => $request['telefono'],
            'correo' => $request['correo'],
            'activo' => $request['activo'],        
            'updated_at' => time_s_now()
        );
        
        $asesor->update($data);
        
        return ['message' => 'Asesor Actualizado'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Asesor  $asesor
     * @return \Illuminate\Http\Response
     */
    public function destroy($key_id)
    {
        $asesor = Asesor::where('key_id','=', $key_id)->firstOrFail();
        $asesor->delete();
        return ['message' => 'Asesor eliminado!'];
    }

    public function getList(Request $request)
    {
        if(!$request->search){
            $result =  Asesor::where('activo', '=', 'si')->get();
            return ['data' => $result];
        }
        $result = Asesor::where('nombre','like', '%'.$request->search.'%')->where('activo', '=', 'si')->get();
        return ['data' => $result];
    }
}

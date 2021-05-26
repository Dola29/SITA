<?php

namespace App\Http\Controllers;

use App\Sustentante;
use Illuminate\Http\Request;
use App\Http\Resources\Sustentante as RSustentante;

class SustentanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request['search'] === null) {
            return Sustentante::all();
        }   
        
        if ($request['search']) {
            $query =  Sustentante::where('nombre', 'like', '%' . $request['search'] . '%')->get();
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
            'nombre' => 'required|string|max:191|unique:sustentantes',
            'matricula' => 'string',
            'telefono' => 'string',
            'correo' => 'string',
            'activo' => 'string|max:2',
        ]);

        return Sustentante::create([           
            'nombre' => $request['nombre'],
            'matricula' => $request['matricula'],
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
     * @param  \App\Sustentante  $sustentante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $key_id)
    {
        $asesor = Sustentante::where('key_id','=', $key_id)->firstOrFail();
        
        $this->validate($request,[
            'nombre' => 'required|string|max:191',
            'matricula' => 'string',
            'telefono' => 'string',
            'correo' => 'string',
            'activo' => 'required|string|max:2',
        ]);

        $data = array(
            'nombre' => $request['nombre'],
            'matricula' => $request['matricula'],
            'telefono' => $request['telefono'],
            'correo' => $request['correo'],
            'activo' => $request['activo'],     
            'updated_at' => time_s_now()
        );
        
        $asesor->update($data);
        
        return ['message' => 'Sustentante Actualizado'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sustentante  $sustentante
     * @return \Illuminate\Http\Response
     */
    public function destroy($key_id)
    {
        $sustentante = Sustentante::where('key_id','=', $key_id)->firstOrFail();
        $sustentante->delete();
        return ['message' => 'Sustentante eliminado!'];
    }

    public function getList(Request $request)
    {
        if(!$request->search){
            $result =  Sustentante::where('activo', '=', 'si')->get();
            return ['data' => $result];
        }
        $result = Sustentante::where('nombre','like', '%'.$request->search.'%')->where('activo', '=', 'si')->get();
        return ['data' => $result];
    }
}

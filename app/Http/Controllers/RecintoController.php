<?php

namespace App\Http\Controllers;

use App\Recinto;
use Illuminate\Http\Request;

use App\Http\Resources\Recinto as RRecinto;

class RecintoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request['search'] === null) {
            return Recinto::all();
        }   
        
        if ($request['search']) {
            $query =  Recinto::where('nombre', 'like', '%' . $request['search'] . '%')->get();
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
            'nombre' => 'required|string|max:191|unique:recintos',
            'descripcion' => 'string',
            'activo' => 'string|max:2',
        ]);

        return Recinto::create([           
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
     * @param  \App\Recinto  $recinto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $key_id)
    {
        $recinto = Recinto::where('key_id','=', $key_id)->firstOrFail();
        
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
        
        $recinto->update($data);
        
        return ['message' => 'Recinto Actualizado'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Recinto  $recinto
     * @return \Illuminate\Http\Response
     */
    public function destroy($key_id)
    {
        $recinto = Recinto::where('key_id','=', $key_id)->firstOrFail();
        $recinto->delete();
        return ['message' => 'Recinto eliminada!'];
    }

    public function getList()
    {
        return RRecinto::collection(Recinto::where('activo', '=', 'si')->get());
    }
}

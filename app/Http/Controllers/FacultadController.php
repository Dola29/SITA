<?php

namespace App\Http\Controllers;

use App\Facultad;
use Illuminate\Http\Request;
use App\Http\Resources\Facultad as RFacultad;

class FacultadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request['search'] === null) {
            return Facultad::all();
        }   
        
        if ($request['search']) {
            $query =  Facultad::where('nombre', 'like', '%' . $request['search'] . '%')->get();
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
            'nombre' => 'required|string|max:191|unique:facultades',
            'activo' => 'string|max:2',
        ]);

        return Facultad::create([           
            'nombre' => $request['nombre'],
            'activo' => $request['activo'],
            'key_id' => generate_key(),
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Facultad  $facultad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $key_id)
    {
        $facultad = Facultad::where('key_id','=', $key_id)->firstOrFail();
        
        $this->validate($request,[
            'nombre' => 'required|string|max:191',
            'activo' => 'required|string|max:2',
        ]);

        $data = array(
            'nombre' => $request['nombre'],
            'activo' => $request['activo'],        
            'updated_at' => time_s_now()
        );
        
        $facultad->update($data);
        
        return ['message' => 'Facultad Actualizada'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Facultad  $facultad
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($key_id)
    {
        $facultad = Facultad::where('key_id','=', $key_id)->firstOrFail();
        $facultad->delete();
        return ['message' => 'Facultad eliminada!'];
    }

    public function getList()
    {
        return RFacultad::collection(Facultad::where('activo', '=', 'si')->get());
    }
}

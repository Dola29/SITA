<?php

namespace App\Http\Controllers;

use App\Escuela;
use Illuminate\Http\Request;
use App\Http\Resources\Escuela as REscuela;

class EscuelaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request['search'] === null) {
            return Escuela::with('facultad')->get();
        }   
        
        if ($request['search']) {
            $query =  Escuela::with('facultad')->where('nombre', 'like', '%' . $request['search'] . '%')->get();
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
            'nombre' => 'required|string|max:191|unique:escuelas',
            'facultad_id'=>'required',
            'activo' => 'string|max:2',
        ]);

        return Escuela::create([           
            'nombre' => $request['nombre'],
            'facultad_id' => $request['facultad_id'],
            'activo' => $request['activo'],
            'key_id' => generate_key(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Escuela  $escuela
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $key_id)
    {
        $escuela = Escuela::where('key_id','=', $key_id)->firstOrFail();
        
        $this->validate($request,[
            'nombre' => 'required|string|max:191',
            'facultad_id'=>'required',
            'activo' => 'required|string|max:2',
        ]);

        $data = array(
            'nombre' => $request['nombre'],
            'facultad_id' => $request['facultad_id'],
            'activo' => $request['activo'],        
            'updated_at' => time_s_now()
        );
        
        $escuela->update($data);
        
        return ['message' => 'Escuela Actualizada'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Escuela  $escuela
     * @return \Illuminate\Http\Response
     */
    public function destroy($key_id)
    {
        $escuela = Escuela::where('key_id','=', $key_id)->firstOrFail();
        $escuela->delete();
        return ['message' => 'Escuela eliminada!'];
    }

    public function getList($facultad_id)
    {
        if($facultad_id == 0){
            return REscuela::collection(Escuela::where('activo', '=', 'si')->get());
        }
        return REscuela::collection(Escuela::where('activo', '=', 'si')->where('facultad_id', $facultad_id)->get());        
    }
}

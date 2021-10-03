<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $usuarios = Usuarios::orderBy('Nombres', 'ASC')->paginate(2);
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $campos = [
            'Nombres' => 'required|string|max:100',
            'Apellidos' => 'required|string|max:100',
            'Telefono' => 'required|min:10|numeric',
            'Correo' => 'required|email|unique:usuarios,Correo',
            'Foto' => 'required|max:10000|mimes:jpeg,png,jpg',
        ];
        $mensaje = [
            'required' => 'El :attribute es requerido',
            'Foto.required' => 'La foto es requerida',
            'Correo.unique' => "El correo ingresado ya existe",
        ];

        $this->validate($request, $campos, $mensaje);

        $datosUsuarios = request()->except('_token');
        if ($request->hasFile('Foto')) {
            $datosUsuarios['Foto'] = $request->file('Foto')->store('uploads', 'public');
        };
        $datosUsuarios['Estatus'] = "Activo";
        Usuarios::insert($datosUsuarios);

        //return response()->json($datosUsers);
        return redirect('usuarios')->with('mensaje', 'Usuario creado con éxito');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usuarios  $usuarios
     * @return \Illuminate\Http\Response
     */
    public function show(Usuarios $usuarios)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Usuarios  $usuarios
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $usuarios = Usuarios::findOrFail($id);
        return view('usuarios.edit', compact('usuarios'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Usuarios  $usuarios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $campos = [
            'Nombres' => 'required|string|max:100',
            'Apellidos' => 'required|string|max:100',
            'Telefono' => 'required|min:10|numeric'


        ];
        $mensaje = [
            'required' => 'El :attribute es requerido'

        ];
        if ($request->hasFile('Foto')) {

            $campos = [

                'Foto' => 'required|max:10000|mimes:jpeg,png,jpg'
            ];
            $mensaje = [
                'Foto.required' => 'La foto es requerida',

            ];
        }

        $this->validate($request, $campos, $mensaje);

        $datosUsuarios = request()->except(['_token', '_method']);

        if ($request->hasFile('Foto')) {
            $usuarios = Usuarios::findOrFail($id);

            Storage::delete('public/' . $usuarios->Foto);

            $datosUsuarios['Foto'] = $request->file('Foto')->store('uploads', 'public');
        }

        Usuarios::where('id', '=', $id)->update($datosUsuarios);
        $usuarios = Usuarios::findOrFail($id);
        // return view('usuarios.edit', compact('usuarios'));

        return redirect('usuarios')->with('mensaje', 'Usuario modificado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usuarios  $usuarios
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $usuarios = Usuarios::findOrFail($id);

        if (Storage::delete('public/' . $usuarios->Foto)) {
            Usuarios::destroy($id);
        }
        return redirect('usuarios')->with('mensaje', 'Usuario eliminado con éxito');
    }

    public function cambiarEstatus($id)
    {
        $usuarios = Usuarios::findOrFail($id);
        $usuarios->Estatus = $usuarios->Estatus === 'Activo' ? 'Inactivo' : 'Activo';
        $usuarios->save();

        return redirect('usuarios')->with('mensaje', 'Cambio de estado exitoso');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = User::clientes()->paginate(10);
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'cedula' => 'required|digits:10',
            'address' => 'nullable|min:6',
            'phone' => 'required',
        ];

        $messages = [
            'name.required' => 'El nombre del cliente es obligatorio',
            'name.min' => 'El nombre del cliente debe tener mas de 3 caracteres',
            'email.required' => 'El correo electronico es obligatorio',
            'email.email' => 'Ingrese una dirreccion de correo valida',
            'cedula.required' => 'El numero de cedula es obligatorio',
            'cedula.digits' => 'La cedula debe tener 10 digitos',
            'address.min' => 'La direccion debe tener al menos 6 digitos',
            'phone.required' => 'El numero de telefono es requerido',
        ];

        $this->validate($request, $rules, $messages);

        User::create(
            $request->only('name', 'email', 'cedula', 'address', 'phone')
            + [
                'role' => 'clientes', 
                'password' => bcrypt($request->input('password'))
            ]
        );
        $notification = 'El cliente se ha registrado correctamente.';
        return redirect('/clientes')->with(compact('notification'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        $cliente = User::clientes()->findOrFail($id);
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'cedula' => 'required|digits:10',
            'address' => 'nullable|min:6',
            'phone' => 'required',
        ];

        $messages = [
            'name.required' => 'El nombre del cliente es obligatorio',
            'name.min' => 'El nombre del cliente debe tener mas de 3 caracteres',
            'email.required' => 'El correo electronico es obligatorio',
            'email.email' => 'Ingrese una dirreccion de correo valida',
            'cedula.required' => 'El numero de cedula es obligatorio',
            'cedula.digits' => 'La cedula debe tener 10 digitos',
            'address.min' => 'La direccion debe tener al menos 6 digitos',
            'phone.required' => 'El numero de telefono es requerido',
        ];

        $this->validate($request, $rules, $messages);
        $user = User::clientes()->findOrFail($id);

        $data =   $request->only('name', 'email', 'cedula', 'address', 'phone');
        $password = $request->input('password');

        if($password)
            $data['password'] = bcrypt($password);


        $user->fill($data);
        $user->save();

        $notification = 'El informacion del cliente se ha actualizado correctamente.';
        return redirect('/clientes')->with(compact('notification'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::clientes()->findOrFail($id);
        $clienteName = $user->name;
        $user->delete();

        $notification = 'El cliente '.$clienteName.' se ha eliminado correctamente.';
        return redirect('/clientes')->with(compact('notification'));
    }
}

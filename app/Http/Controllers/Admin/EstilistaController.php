<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Services;

class EstilistaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estilistas = User::estilistas()->paginate(10);
        return view('estilistas.index', compact('estilistas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Services::all();
        return view('estilistas.create', compact('services'));
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
            'name.required' => 'El nombre del estlista es obligatorio',
            'name.min' => 'El nombre del estlista debe tener mas de 3 caracteres',
            'email.required' => 'El correo electronico es obligatorio',
            'email.email' => 'Ingrese una dirreccion de correo valida',
            'cedula.required' => 'El numero de cedula es obligatorio',
            'cedula.digits' => 'La cedula debe tener 10 digitos',
            'address.min' => 'La direccion debe tener al menos 6 digitos',
            'phone.required' => 'El numero de telefono es requerido',
        ];

        $this->validate($request, $rules, $messages);

        $user = User::create(
            $request->only('name', 'email', 'cedula', 'address', 'phone')
            + [
                'role' => 'estilista', 
                'password' => bcrypt($request->input('password'))
            ]
        );
        $user->services()->attach($request->input('services'));
        $notification = 'El estilista se ha registrado correctamente.';
        return redirect('/estilistas')->with(compact('notification'));
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
    public function edit( $id)
    {
        $estilista = User::estilistas()->findOrFail($id);

        $services = Services::all();
        $services_ids = $estilista->services()->pluck('services.id');

        return view('estilistas.edit', compact('estilista', 'services', 'services_ids'));
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
            'name.required' => 'El nombre del estlista es obligatorio',
            'name.min' => 'El nombre del estlista debe tener mas de 3 caracteres',
            'email.required' => 'El correo electronico es obligatorio',
            'email.email' => 'Ingrese una dirreccion de correo valida',
            'cedula.required' => 'El numero de cedula es obligatorio',
            'cedula.digits' => 'La cedula debe tener 10 digitos',
            'address.min' => 'La direccion debe tener al menos 6 digitos',
            'phone.required' => 'El numero de telefono es requerido',
        ];

        $this->validate($request, $rules, $messages);
        $user = User::estilistas()->findOrFail($id);

        $data =   $request->only('name', 'email', 'cedula', 'address', 'phone');
        $password = $request->input('password');

        if($password)
            $data['password'] = bcrypt($password);


        $user->fill($data);
        $user->save();
        $user->services()->sync($request->input('services'));

        $notification = 'El informacion del estilista se ha actualizado correctamente.';
        return redirect('/estilistas')->with(compact('notification'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::estilistas()->findOrFail($id);
        $doctorName = $user->name;
        $user->delete();

        $notification = 'El estilista '.$doctorName.' se ha eliminado correctamente.';
        return redirect('/estilistas')->with(compact('notification'));

    }
}

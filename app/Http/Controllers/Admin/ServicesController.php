<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Services;
use App\Http\Controllers\Controller;

class ServicesController extends Controller
{

    

    public function index(){
        $services = Services::all();
        return view('services.index', compact('services'));
    }

    public function create(){
        return view('services.create');
    }

    public function sendData(Request $request){

        $rules = [
            'name' => 'required|min:3'
        ];
        $messages = [
            'name.required' => 'El nombre del servicio es obligatorio.',
            'name.min' => 'El nombre del servicio debe tener mas de 3 caracteres.'
        ];

        $this->validate($request, $rules, $messages);

        
        $services = new Services();
        $services->name = $request->input('name');
        $services->description = $request->input('description');
        $services->save();
        $notification = 'El servicio se ha creado correctamente.';

        return redirect('/services')->with(compact('notification'));
    }  
    
    public function edit(Services $services){

        return view('services.edit', compact('services'));
    }

    public function update(Request $request, Services $services){

        $rules = [
            'name' => 'required|min:3'
        ];
        $messages = [
            'name.required' => 'El nombre del servicio es obligatorio.',
            'name.min' => 'El nombre del servicio debe tener mas de 3 caracteres.'
        ];

        $this->validate($request, $rules, $messages);

        
        $services->name = $request->input('name');
        $services->description = $request->input('description');
        $services->save();
        $notification = 'El sercivio se ha actualizado correctamente.';

        return redirect('/services')->with(compact('notification'));
    }  

    public function destroy(Services $services){
        $deleteName = $services->name;
        $services->delete();
        $notification = 'El servicio '. $deleteName .' se ha eliminado correctamente.';

        return redirect('/services')->with(compact('notification'));
    }

}

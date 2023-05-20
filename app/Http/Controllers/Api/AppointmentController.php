<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointment;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index (){
        $user = Auth::guard('api')->user();
        $appointments = $user->asClientesAppointment()
        ->with(['services' => function ($query) {
            $query->select('id', 'name');
        }
        , 'estilista' => function ($query) {
            $query->select('id', 'name');
        }])
        ->get([
            "id",
            "scheduled_date",
            "scheduled_time",
            "estilista_id",
            "services_id",
            "created_at",
            "status"
        ]);
        return $appointments;
    }

    public function store(StoreAppointment $request){
        $clienteId = Auth::guard('api')->id();
        $appointment = Appointment::createForCliente($request, $clienteId);

        if($appointment)
            $success = true;
          else
            $success = false;

        return compact('success');
    }

 
}

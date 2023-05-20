<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointment;
use App\Interfaces\HorarioServiceInterface;
use App\Models\Services;
use App\Models\Appointment;
use App\Models\CancellAppointment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{

    public function index(){

        $role = auth()->user()->role;

        if($role == 'admin'){
            //Admin
            $confirmedAppointments = Appointment::where('status', 'Confirmada')
            ->get();
    
            $pendingAppointments = Appointment::where('status', 'Reservado')
            ->get();
    
            $oldAppointments = Appointment::whereIn('status', ['Atendida', 'Cancelada'])
            ->get();
      
        }

        elseif($role == 'estilista'){
            
            //Estilista
            $confirmedAppointments = Appointment::where('status', 'Confirmada')
            ->where('estilista_id', auth()->id())
            ->get();
    
            $pendingAppointments = Appointment::where('status', 'Reservado')
            ->where('estilista_id', auth()->id())
            ->get();
    
            $oldAppointments = Appointment::whereIn('status', ['Atendida', 'Cancelada'])
            ->where('estilista_id', auth()->id())
            ->get();
      

        }elseif($role == 'cliente'){
            
        //Clientes
        $confirmedAppointments = Appointment::where('status', 'Confirmada')
        ->where('cliente_id', auth()->id())
        ->get();

        $pendingAppointments = Appointment::where('status', 'Reservado')
        ->where('cliente_id', auth()->id())
        ->get();

        $oldAppointments = Appointment::whereIn('status', ['Atendida', 'Cancelada'])
        ->where('cliente_id', auth()->id())
        ->get();

        }


        return view('appointment.index', compact('confirmedAppointments', 'pendingAppointments', 'oldAppointments', 'role'));
    }



    public function create(HorarioServiceInterface $horarioServiceInterface){
        $services = Services::all();

        $serviceId = old('services_id');
        if($serviceId){
            $service = Services::find($serviceId);
            $estilistas = $service->users();
        } else{
                $estilistas = collect();
        }

        $date = old('scheduled_date');
        $estilistaId = old('estilista_id');
        if($date && $estilistaId){
            $intervals = $horarioServiceInterface->getAvailableIntervals($date, $estilistaId);
        }else{
            $intervals = null;
        }

        return view('appointment.create', compact('services', 'estilistas', 'intervals'));
    }

    public function store(StoreAppointment $request, HorarioServiceInterface $horarioServiceInterface){
        $created = Appointment::createForCliente($request, auth()->id());
        if($created) {
            $notification = 'La cita se ha realizado correctamente.';
        } else {
            $notification = 'Error al registrar la cita';
        }
        return back()->with(compact('notification'));
    }
    

    public function cancel(Appointment $appointment, Request $request){
        if($request->has('justification')){
            $cancellation = new CancellAppointment();
            $cancellation->justification = $request->input('justification');
            $cancellation->cancelled_by_id = auth()->id();

            $appointment->cancellation()->save($cancellation);
        }
        $appointment->status = 'Cancelada';
        $appointment->save();
        $notification = 'La cita se ha cancelado correctamente';

        return redirect('/miscitas')->with(compact('notification'));
    }

    public function confirm(Appointment $appointment){
      
        $appointment->status = 'Confirmada';
        $appointment->save();
        $notification = 'La cita se ha confirmado correctamente';

        return redirect('/miscitas')->with(compact('notification'));
    }

    public function formCancel(Appointment $appointment){
        $role = auth()->user()->role;
        if($appointment->status == 'Confirmada'){
            return view('appointment.cancel', compact('appointment', 'role'));
        }
        return redirect('/miscitas');
        
    }

    public function show(Appointment $appointment){

        $role = auth()->user()->role;
        return view('appointment.show', compact('appointment', 'role'));
    }
}

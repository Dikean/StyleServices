<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function appointments(){
        
      $monthCounts =  Appointment::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(1) as count'))
                ->groupBy('month')
                ->get()
                ->toArray();

                $counts = array_fill(0, 12 , 0);
                foreach($monthCounts as $mountCount){
                    $index = $mountCount['month']-1;
                    $counts[$index] = $mountCount['count'];
                }

            
        
        return view('charts.appointments', compact('counts'));
    }

    public function estilistas(){
        return view('charts.estilistas');
    }

    public function estilistasJson(){
        $estilistas = User::estilistas()
        ->select('name')
        ->withCount(['attendedAppointments', 'cancellAppointments'])
        ->orderBy('attended_appointments_count', 'desc')
        ->take(5)
        ->get();

        $data = [];
        $data['categories'] = $estilistas->pluck('name');
        
        $series = [];
        $series1['name'] = 'Citas atendidas';
        $series1['data'] = $estilistas->pluck('attended_appointments_count');
        $series2['name'] = 'Citas candeladas';
        $series2['data'] = $estilistas->pluck('cancell_appointments_count');
        $series[] = $series1;
        $series[] = $series2;
        $data['series'] = $series;

        return $data;
    }
}

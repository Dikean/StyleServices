<?php namespace App\Services;

use App\Interfaces\HorarioServiceInterface;
use App\Models\Appointment;
use App\Models\Horarios;
use Carbon\Carbon;

class HorarioService implements HorarioServiceInterface{

    private function getDayFromDate($date){
        $dateCarbon = new Carbon($date);
        $i = $dateCarbon->dayOfWeek;
        $day = ($i==0 ? 6 : $i-1);
        return $day;
    }

    public function isAvailableIntervals($date, $estilista_Id, Carbon $start){
        $exists = Appointment::where('estilista_id', $estilista_Id)
        ->where('scheduled_date', $date)
        ->where('scheduled_time', $start->format('H:i:s'))
        ->exists();

        return !$exists;
    }

    public function getAvailableIntervals($date, $estilista_Id){
        $horario = Horarios::where('active', true)
        ->where('day', $this->getDayFromDate($date))
        ->where('user_id', $estilista_Id)
        ->first([
            'morning_start',  'morning_end',
            'afternoon_start',  'afternoon_end'
        ]);

        if($horario){
            $morningIntervalos = $this->getIntervalos(
                $horario->morning_start, $horario->morning_end, $estilista_Id, $date
            );
            $afternoonIntervalos = $this->getIntervalos(
                $horario->afternoon_start, $horario->afternoon_end, $estilista_Id, $date
            );
        }else{
            $morningIntervalos = [];
            $afternoonIntervalos = [];
        }
     
        $data = [];
        $data['morning'] = $morningIntervalos;
        $data['afternoon'] = $afternoonIntervalos;
        return $data;
    }

    private function getIntervalos($start, $end, $estilista_Id, $date){
        $start = new Carbon($start);
        $end = new Carbon($end);

        $intervalos = [];
        while($start < $end){
            $intervalo = [];
            $intervalo['start'] = $start->format('g:i A');

          $available = $this->isAvailableIntervals($date, $estilista_Id, $start);
          
            $start->addMinutes(30);
            $intervalo['end'] = $end->format('g:i A');

            if($available){
                 $intervalos []= $intervalo;
            }   
           
        }
        return $intervalos;
    }
}
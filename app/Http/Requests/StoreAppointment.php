<?php

namespace App\Http\Requests;

use App\Interfaces\HorarioServiceInterface;
use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class StoreAppointment extends FormRequest
{

    private $horarioService;

    public function __construct(HorarioServiceInterface $horarioServiceInterface)
    {
        $this->horarioService = $horarioServiceInterface;
    }
  
    public function rules(): array
    {
        return [
       
                'scheduled_date' => 'required',
                'estilista_id' => 'exists:users,id',
                'services_id' => 'exists:services,id'
         
        ];
    }

    public function messages()
    {
        return[
            'scheduled_date.required' => 'Debes seleccionar una fecha valida para su cita'
        ];
    }

    public function withValidator($validator)
    {
       
        $validator->after(function ($validator) {

            $date = $this->input('scheduled_date');
            $estilistaId = $this->input('estilista_id');
            $scheduled_time = $this->input('scheduled_time');

            if($date && $estilistaId && $scheduled_time){
                $start = new Carbon($scheduled_time);
            } else{
                return;
            }

            if (!$this->horarioService->isAvailableIntervals($date, $estilistaId, $start)) {
                $validator->errors()->add(
                    'available_time', 'La hora seleccionada ya se encuentra seleccionada por otro paciente.'
                );
            }
        });
        
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'scheduled_date',
        'scheduled_time',
        'estilista_id',
        'cliente_id',
        'services_id'
    ];

    protected $hidden = [
        'scheduled_time',
        'services_id',
        'estilista_id'
    ];

    protected $appends = [
        'scheduled_time_12'
    ];

    public function services(){
        return $this->belongsTo(Services::class);
    }
    public function estilista(){
        return $this->belongsTo(User::class);
    }

    public function cliente(){
        return $this->belongsTo(User::class);
    }

    public function getScheduledTime12Attribute(){
        return (new Carbon($this->scheduled_time))
            ->format('g:i A');
    }

    public function cancellation(){
        return $this->hasOne(CancellAppointment::class);
    }

    static public function createForCliente(Request $request, $clienteId)
    {

        $data = $request->only([
            'scheduled_date',
            'scheduled_time',
            'estilista_id',
            'services_id'
            ]);
            $data['cliente_id'] = $clienteId;
    
            $carbonTime = Carbon::createFromFormat('g:i A', trim($data['scheduled_time'], '}'));
            $data['scheduled_time'] = $carbonTime->format('H:i:s');

            return self::create($data);
    }

}


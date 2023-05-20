<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cedula', 
        'address',
         'phone',
         'role'   
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pivot',
    ];

    public static $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ];

    public static function createClient (array $data)
    {
        return self::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => 'cliente',
            'password' => Hash::make($data['password']),
        ]);
    }

    public function services(){
        return $this->belongsToMany(Services::class)->withTimestamps();
    }
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeClientes($query){
        return $query->where('role', 'cliente');
    }

    public function scopeEstilistas($query){
        return $query->where('role', 'estilista');
    }

    public function asEstilistaAppointment(){
        return $this->hasMany(Appointment::class, 'estilista_id');
    }
    

    public function attendedAppointments(){
        return $this->asEstilistaAppointment()->where('status', 'Atendida');
    }

    public function cancellAppointments(){
        return $this->asEstilistaAppointment()->where('status', 'Cancelada');
    }
    public function asClientesAppointment(){
        return $this->hasMany(Appointment::class, 'cliente_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}

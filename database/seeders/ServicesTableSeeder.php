<?php

namespace Database\Seeders;

use App\Models\Services;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            'Corte de cabello',
            'Manicure',
            'Pedicure',
            'Cuidado de barba',
            'Tratamiento Capilar',
            'Rayitos',
            'Tintes'
        ];
        foreach ($services as $serviceName) {
       $service = Services::create([
            'name' => $serviceName
        ]);
        $service->users()->saveMany(
            User::factory(4)->state(['role' => 'estilista'])->make()
        );
    }
    User::find(2)->services()->save($service);
}
}
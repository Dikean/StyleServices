<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AppointmentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween('-1 years', 'now');
        $scheduled_date = $date->format('Y-m-d');
        $scheduled_time = $date->format('H:i:s');
        $estilistaIds = User::estilistas()->pluck('id');
        $clienteIds = User::clientes()->pluck('id');
        $statuses = ['Atendida', 'Cancelada'];

        return [
        'scheduled_date' => $scheduled_date,
        'scheduled_time' => $scheduled_time,
        'estilista_id' => $this->faker->randomElement($estilistaIds),
        'cliente_id' => $this->faker->randomElement($clienteIds),
        'services_id' => $this->faker->numberBetween(1,7),
        'status' => $this->faker->randomElement($statuses)
        ];
    }
}

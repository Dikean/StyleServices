<?php namespace App\Interfaces;

use Carbon\Carbon;

interface HorarioServiceInterface {
    public function isAvailableIntervals($date, $estilista_Id, Carbon $start);
    public function getAvailableIntervals($date, $estilista_Id);
}
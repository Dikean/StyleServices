<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Services;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(){
        return Services::all(['id', 'name']);
    }

    public function estilistas(Services $services){
        return $services->users()->get([
            'users.id',
            'users.name'
        ]);
    }

}

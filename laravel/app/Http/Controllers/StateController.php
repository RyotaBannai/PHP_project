<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index(){
        return response()
        ->view('state.index')
        ->cookie('app_title', 'laravel', 60 * 24 * 30); //one month
        // name, value, valid duration( minutes), path, domain, allow only via https (true or false)
    }
}

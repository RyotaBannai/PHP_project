<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Gate;

class TestGateController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request){

        $someArr = [1,2,3];
        //Gate::authorize('return-from-validation', $someArr);
        if(Gate::allows('return-from-validation')){
            return 'hi';
        }
        else{
            return 'not hi';
        }
    }
}

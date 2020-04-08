<?php


namespace App\Http\Controllers;
use BaseFunctions;

class SameFunctionsController
{
    public function index(){
        return BaseFunctions::dojobs();
    }
}

<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function master(){
		return view('view.master', [
			'msg' => 'Hi!',
		]);
	}

    public function comp(){
	    return view('view.comp', [
		    'msg' => 'Hi!',
		]);
	}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Route;

class RoutesController extends Controller
{
    private $val = '';
    public function __construct()
    {
    }
    public function index()
    {
    }
    public function sendAllParms(Request $request)
    {
        $val = $request->input();// get all as associated array
        // $val = $request->all();// get all a simple array

        $q = $request->query();
        $r = $request->route('user');
        // $r = Route::current()->parameter('user'); // これでもパラメータ取得可
        return view('view.routes', compact('val', 'r'));


        if (! $request->hasValidSignature()) { // サインを検証
            abort(404);
        }
        else{
            return view('view.routes', compact('val'));
        }
    }
}

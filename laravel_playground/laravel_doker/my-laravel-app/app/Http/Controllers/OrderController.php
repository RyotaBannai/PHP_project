<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function order(Request $req){
        return view('order.ordered');
    }
    public function ordered(Request $req){
        event(new \App\Events\ShippingStatusUpdated($req->get('message')));
        return 'public';
    }
}

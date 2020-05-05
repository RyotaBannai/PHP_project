<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Events\OrderShipped;
use App\Models\Flight;
use App\Jobs\SendShipmentNotificationJobs;

class LogController extends Controller
{
    public function index(Request $request)
    {
//        Log:info('Slack Test - Info');
//        return view('welcome');
        // slackへのログ処理を listner に行わせる
        event(new OrderShipped());
        //SendShipmentNotificationJobs::dispatch();
        return '🔥Fired the event🔥';
    }
}

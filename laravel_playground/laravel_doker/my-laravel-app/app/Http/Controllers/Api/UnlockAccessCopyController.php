<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UnlockAccessCopyController extends Controller
{
    public function __invoke(Request $request)
    {

        // get id from profile user id and action user id.
        //\Session::forget('key');
        //\Session::push($this->session_id);
        // user id + uuid + model instance id
        return true;
    }
}

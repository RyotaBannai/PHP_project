<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    private $uid;
    public function __construct()
    {
        $this->uid = null;
    }


    public function index(Request $request)
    {
        $sid = $request->session()->regenerate(); // セッションID
        $this->uid = 'key-'.$request->id;
        if($request->session()->exists($this->uid)){ // existはnullでもtrueを返し、 hasはnullもerror。
            $value = $request->session()->get($this->uid);
            session([$this->uid => $value+1]);
            // $request->session()->put($this->uid, $this->count)
            return "<div class = 'blue'> You visited ".($value+1)." times.</div>";
        }
        else{
            session([$this->uid => 1]);
            return "<div class = 'red'>You don't have any session.</div>";
        }

//        $initial = 0 ;
//        $value = $request->session()->get($this->uid, function() use ($initial){
//            session([$this->uid => $initial]);
//            return  "You don't have any session.";
//        });
//        // closure でreturnされない
//        session([$this->uid => $value+1]);
//        return $value+1;
    }

}

<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $type;
    public $message;
    public $alertType;
    public function __construct($alertType)
    {
//        $this->type = $type;
//        $this->message = $message;
            $this->alertType = $alertType;
    }

    public function size(){
        return "XS";
    }
    public function render()
    {
        return view('components.alert');
    }
}

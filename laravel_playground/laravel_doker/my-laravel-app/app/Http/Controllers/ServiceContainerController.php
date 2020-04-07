<?php

namespace App\Http\Controllers;

interface Animal{
    public function cry();
}

class Dog implements Animal {
    public function cry()
    {
        return 'arf-arf';
    }
}

// Service Binding
$this->app->bind('dog', 'Dog');

class ServiceContainerController
{
    private $myPetCry;
    public function __construct()
    {
        $this->myPetCry = $this->app->make('dog');
    }
    public function index(){
        return view('view.index', [
            'data'=> $this->myPetCry,
        ]);
    }

}

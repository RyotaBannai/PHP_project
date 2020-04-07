<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController; // Controllerを継承する利点ってなに

use Pimple\Container;

class PimpleController extends BaseController
{
    private $container;
    public function __construct()
    {
       $this->container = new Container();
    }
}

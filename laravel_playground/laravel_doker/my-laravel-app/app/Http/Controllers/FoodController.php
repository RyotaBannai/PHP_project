<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;

class FoodController extends Controller
{
    public function index(Request $req)
    {
        $items = Ingredient::all();
        return view(
            'food.index',
            ['items'=>$items]
        );
    }
}

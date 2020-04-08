<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $req)
    {
        $users = User::all();
        return view(
            'user.index',
            ['users'=>$users]
        );
    }
}

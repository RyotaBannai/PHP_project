<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class BookController extends Controller
{
    public function index(){
        return view('book.list', [
            //'books' => Book::where('publisher','翔泳社')->get(),
            //'books' => Book::where('price','<', 3000)->get(), //大小比較
            'books' => Book::where('title','LIKE', '%PHP%')->get(), //部分一致検索
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index()
    {
        return view('file.form');
    }
    public function upload(Request $request)
    {
        $file = $request->file('file');
        // 第一引数はディレクトリの指定
        // 第二引数はファイル
        // 第三引数はpublicを指定することで、URLによるアクセスが可能となる
        $path = Storage::disk('s3')->putFile('/main', $file, 'public');
        // hogeディレクトリにアップロード
        // $path = Storage::disk('s3')->putFile('/hoge', $file, 'public');
        // ファイル名を指定する場合はputFileAsを利用する
        // $path = Storage::disk('s3')->putFileAs('/', $file, 'hoge.jpg', 'public');
        return redirect('/');
    }
    public function show()
    {
        $file_name = 'main/juPHonlQgCDdEQh6WjhuUvsiZXSkjYqNHC9BFdFI.jpeg';
        $path = Storage::disk('s3')->url($file_name);
        return view('file.show', compact('path'));
    }
}

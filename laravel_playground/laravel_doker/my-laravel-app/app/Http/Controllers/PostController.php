<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;

class PostController extends Controller
{
    public function comment(Request $request){
        $comment = new Comment();
        $comment->target_id = 1;
        $comment->target_type = 'App\Models\Comment';
        // imageを同じtarget_id で保存するときは、modelインスタンスを見つけてきて、そのcreateメソッドを実行。
        $comment->body = "Some random texts.";
        $comment->save();
        $comment->images()->create(['filename' => "test_file.mp4"]); // Morph target_type is App\Models\Comments
        return view('welcome');
    }

    public function show(Request $request){
        $posts = new Post();
        return view('post.index');
    }
}

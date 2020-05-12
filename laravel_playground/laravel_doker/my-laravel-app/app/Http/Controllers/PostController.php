<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;

class PostController extends Controller
{
    public function comment(Request $request)
    {
        $comment = new Comment();
        $comment->target_id = 1;
        $comment->target_type = 'App\Models\Comment';
        // imageを同じtarget_id で保存するときは、modelインスタンスを見つけてきて、そのcreateメソッドを実行。
        $comment->body = "Some random texts.";
        $comment->save();
        $comment->images()->create(['filename' => "test_file.mp4"]); // Morph target_type is App\Models\Comments
        return view('welcome');
    }

    public function attachTag($post_id = 1, $tag_id = [1,2,3])
    {

        $post = Post::find($post_id);
        // $post->tags()->attach($tag_id); // detach() is the opposite.
        $post->tags()->sync($tag_id);
        // $post->tags() でpostに紐づいたタグ一覧を取得。
        // attachメソッドにタグidの配列を渡すことによってpost_tagに一気にタグを登録
        // syncメソッドを使うと、指定したIDのみを保存し、それ以外を削除
    }

    public function show(Request $request)
    {
        $posts = Post::with(['comments.images', 'comments.comments.images', 'images'])->take(1)->get();
        // take(1)->get() will return a collection with one element. first() will return element itself.
        return view('post.show', compact('posts'));
    }
}

@foreach($posts as $post)
    <h3> {{ $post->title }}</h3>
    <p>User ID: {{ $post->user_id }}</p>
    <p>Content: <br> {{ $post->content }}</p>
    <p>Category: {{ $post->category }}</p>
    <div style="background-color: #e0e0e0">
        Used Images: <br>
        @foreach($post->images as $image)
            <p>{{ $image->filename }}</p>
        @endforeach
    </div>
    <hr>
    <div style="margin-left: 15px;">
       @foreach($post->comments as $comment)
           <p>{{ $comment->id }}: {{ $comment->body }} To post: {{ $post->id }}</p>
           <div style="background-color: #e0e0e0">
               Used Images: <br>
               @foreach($comment->images as $image)
                   <p>{{ $image->filename }}</p>
               @endforeach
           </div>
           @foreach($comment->comments as $sub_comment)
               <p style="margin-left: 15px;">{{ $sub_comment->id }}: {{ $sub_comment->body }} To comment: {{ $comment->id }} </p>
               <div style="background-color: #e0e0e0; margin-left: 15px;">
                   Used Images: <br>
                   @foreach($sub_comment->images as $image)
                       <p>{{ $image->filename }}</p>
                   @endforeach
               </div>
           @endforeach
       @endforeach
    </div>
@endforeach

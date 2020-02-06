@foreach($books as $book => $value)
  <p>{{ $book.', '.$value->title.', '.$value->price }}</p>
@endforeach
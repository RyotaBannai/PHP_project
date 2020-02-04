<!DOCTYPE html>
<html>
  <head>
	  <meta charset="UTF-8"/>
    <title>Laravel速習!</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"/>
  </head>
  <body>
    <table>
      <tr>
        <th>Name</th>
        <th>Price</th>
        <th>Publisher</th>
        <th>Published Date</th>
      </tr>
      @foreach($records as $record)
      <tr>
        <th>{{$record->title}}</th>
        <th>{{$record->price}}円</th>
        <th>{{$record->publisher}}</th>
        <th>{{$record->published}}</th>
      </tr>
      @endforeach
    </table>
  </body>
</html>
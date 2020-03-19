@extends('layouts.base')
@section('main')
<form method="POST" action="/ctrl/form">
{{-- csrf: 入力値が正しいフォームから送信されているかを保証. --}}
@csrf
  <label for="name">Name: </label>
  <input id="name" name="nameval" type="text" />
  <input type="submit" valye="Submit" />
  <p>Hello, 
  @if($result)
    {{ $result }}!
  @else
    visitor!
  @endif
  </p>
</form>
@endsection
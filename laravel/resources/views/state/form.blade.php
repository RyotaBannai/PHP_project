@extends('layouts.base')
@section('title','State Management.')
@section('main')
  @if(session('alert'))
  <div class="alert alert-warning">{{ session('alert') }}</div>
  @endif
  <form method="POST" action="/state/check">
  {{-- csrf: 入力値が正しいフォームから送信されているかを保証. --}}
  @csrf
    <label for="name">Name: </label>
    <input id="name" name="nameval" type="text" value="{{ old('nameval', '')}}" />
    <input type="submit" valye="submit" />
  </form>
@endsection
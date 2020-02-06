@extends('layouts.base')
@section('title','State Management.')
@section('main')
  <div>State management.</div>
  <p>registered state is: {{ $msg.', '}} </p>
  @foreach($state as $key => $value)
    <hr/>
    <p>{{ $key.' -> '}}</p>
    @if(is_array($value) || is_object($value))
      @foreach($value as $elem)
        <span>{{serialize($elem)}} , </span>
      @endforeach
    @endif
  @endforeach
@endsection
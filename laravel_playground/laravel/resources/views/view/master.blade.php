@extends('layouts.base')
@section('title','共通レイアウトの基本.')
@section('main')
  <div>this is the content of shared layouts: @parent</div>
  <p>{{ $msg }}</p>
@endsection
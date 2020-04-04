@extends('layouts.base')
@section('title', '共通のレイアウト.')
@section('main')
  @component('components.alert', ['type'=>'success'])
    @slot('alert_title')
      初めてのコンポネント
    @endslot
    コンポネントは普通のviewを同じように.blade.phpファウルで定義できる!
  @endcomponent
@endsection
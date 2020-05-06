@extends('order.parent')
@section('content')
    <div id="app">
        <example-component></example-component>
    </div>
@endsection
@section('script')
    @component('order.script') @endcomponent
@endsection

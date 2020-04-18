@extends('user.form')

@section('title','TTTTITLE')
@include('common.head', ['description'=>'DEEEESCRIPTION'])

@include('common.error', ['text' => 'error... right'])

@push('sidebar')
    <li>Sidebar list item</li>
@endpush

@prepend('sidebar')
    <li>First Sidebar Item</li>
@endprepend

@section('scripts')
#4 something special things to dot down! <br>
@endsection

@section('parent__')
    @parent
    <p>new line </p>
@endsection

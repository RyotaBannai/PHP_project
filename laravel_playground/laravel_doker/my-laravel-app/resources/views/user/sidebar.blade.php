@extends('user.form')

@section('title','TTTTITLE')
@include('common.head', ['description'=>'DEEEESCRIPTION'])

@include('common.error', ['text' => 'error... right'])

@component('components.message')
    @slot('error')
        This is a dummy message just for testing purpose.
    @endslot
@endcomponent

@component('components.message')
    @slot('success')
        You are success to log in!
    @endslot
@endcomponent

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

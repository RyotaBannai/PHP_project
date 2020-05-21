@extends('layouts.layout')
@section('content')
    <button-section-submit v-bind:user_id="{{ $user->id }}">@csrf</button-section-submit>
@endsection

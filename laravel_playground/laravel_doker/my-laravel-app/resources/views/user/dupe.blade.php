@extends('layouts.layout')
@section('content')
    <button-section-submit v-bind:user_id="{{ $user->id }}" url="{{url('users/'.$user->id)}}" >
        <template #csrf-token>@csrf</template>
    </button-section-submit>
@endsection

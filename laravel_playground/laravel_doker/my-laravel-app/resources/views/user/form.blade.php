{{ Form::open(array('route' => array('user.out'), 'class' => 'section-top')) }}
{{ Form::select('animal', array(
    'Cats' => array('leopard' => 'Leopard'),
    'Dogs' => array('spaniel' => 'Spaniel'),
))}}
{{ dump('[{"id":10, "haha": "greet"}]') }}


@php ($x = 5)@endphp
<button class="btn btn-danger" type="submit">Submit</button>
{{ Form::close() }}
<pre>
@php
    echo "#1";
@endphp

@php
    echo "#2";
@endphp
@verbatim
#3
@endverbatim
</pre>

@inject('sayhi', 'App\Services\Myfacade')
{!! $sayhi->SayHi() !!}


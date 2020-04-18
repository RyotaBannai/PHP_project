@yield('head')

{{ Form::open(array('route' => array('user.out'), 'class' => 'section-top')) }}
{{ Form::select('animal', array(
    'Cats' => array('leopard' => 'Leopard'),
    'Dogs' => array('spaniel' => 'Spaniel'),
))}}
@dump ('[{"id":10, "haha": "greet"}]')


@php ($x = 5)@endphp
<button class="btn btn-danger" type="submit">Submit</button>
{{ Form::close() }}
<pre>
  ___________________________
< I'm an expert in my field. >
  ---------------------------
         \   ^__^
          \  (oo)\_______
             (__)\       )\/\
                 ||----w |
                 ||     ||
  </pre>
<div>
@php
    echo "#1", PHP_EOL;
@endphp

@php
    echo "#2", PHP_EOL;
@endphp
@verbatim
#3 <br>
@endverbatim
@yield("scripts")
@section("parent__")
<p>what's up!!</p>
@show
</div>

@inject('sayhi', 'App\Services\Myfacade')
{!! $sayhi->SayHi() !!}


<ul id="sidebar">
    @stack('sidebar')
</ul>

@foreach([1,2,3,4] as $n)
    @if($loop->index ==2 )
        @continue
    @else
        <li>{{ $loop->index }}</li>
    @endif
@endforeach

@php
    $message = 'hello world';
@endphp
<x-foot :message="$message"/>
<x-alert alert-type="danger" type="error" :message="$message"/>

<!DOCTYPE html>
<html>
  <head>
	  <meta charset="UTF-8"/>
    <title>Laravel速習!</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"/>
  </head>
  <body>
    {{-- 同名の.phpファイルと.blade.phpが混在する場合, .blade.phpが優先される.--}}
    <p>{!! $html !!}</p>
    @verbatim
    <p>{{ $verbatim }}</p>
    @endverbatim
    <!-- これは表示されます.-->
    {{-- これはコメントです.クライアントには、送信されません.--}}
    @if($random < 50)
    <p>{{ $random }} は, 50未満です. </p>
    @else
    <p>{{ $random }} は, 50以上です. </p>
    @endif 
    @isset($emptystring)
    <p>$emptystringは,カラのstring型です. カラでも定義されていれば, true. </br> nullがsetされていれば, false.</p>
    @endisset
    @empty($null)
    <p>empty directive はnullだとtrue.</p>
    @endempty
    <hr>
    @php
      $i=0;
      $hash= array('バナナ', 'apple'=>'りんご', 'peach'=>'もも', 'pear'=>'なし', 'みかん');
      $days= ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
      $emptyarray = [];
    @endphp
    @while($i < 3)
      @php
        $i++;
      @endphp
      <h{{$i}}>h{{$i}}番目です.</h{{$i}}>
    @endwhile
    @foreach($hash as $id => $value)
      <ul>
        <li>{{$id.': '.$value}}</li>
      </ul>
    @endforeach
    <p>$loopを使えば、特殊な要素を取得することができる.last, first, even, odd, depth, parent</p>
    @foreach($days as $ind => $value)
      @break($loop->iteration > 3) 
      <ul>
        <li>{{'Remains... '.$loop->remaining}}</li>
      </ul>
    @endforeach
    {{-- $loop はfor文の場合は多分使えない. 変数から値を取得できるため. --}}
    @for($j=0; $j < 3; $j++)
      @for($k=0; $k < 3; $k++)
        
        <p></p>
        
      @endfor
    @endfor
    @php
      $users = array();
    @endphp

    @forelse ($users as $user)
      <li>{{ $user->name }}</li>
    @empty
      <p>No users</p>
    @endforelse
  </body>
</html>
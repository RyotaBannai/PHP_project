<div class='alert alert-{{$type}}'>
  <h4 class='alert-heading'>{{$alert_title}}</h4>
  <p>{{$slot}}</p>
  {{-- component配下で, slotで括られなかったコンテンツはslot変数に格納される. 基本的にはcomponent内はslotで括らず, そのまま表示するのが一般的.--}}
</div>
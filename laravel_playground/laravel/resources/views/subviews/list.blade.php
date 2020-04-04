@extends('layouts.base')
@section('title', '共通のレイアウト.')
@section('main')
  <table>
    <tr>
      <th>書名</th>
      <th>価格</th>
      <th>出版社</th>
      <th>発行日</th>
    </tr>
    {{-- foreach + includeで代用可能. --}}
    @each('subviews.book', $records, 'record', 'subviews.empty')
  </table>
@endsection
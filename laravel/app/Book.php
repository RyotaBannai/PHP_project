<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
  /*
		他の名前を明示的に指定しない限り、クラス名を複数形の「スネークケース」にしたものが、
		テーブル名として使用される。例えば、EloquentはFlightモデルをflightsテーブルに保存する.
  */
	// protected $table = 'my_flights';

	//もし主キーを変更したければ、以下のようにする。
	// protected $primaryKey = 'isbn';
	// protedted $keyType = 'string' //from int
	// public $incrementing = false; //default is true
	
}

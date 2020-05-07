<?php
namespace App\Playground;
use Illuminate\Support\Collection;
use Str;
use Arr;


class Helpers
{
    private $_data;
    public function __construct()
    {
        include 'Warehouse/data.php';
        $this->_data = $__data;
    }

    public function _arr()
    {
        $data = $this->_data;
        $arr = [1,2,3];
        $array = ['products' => ['desk' => ['price' => 100]]];
        $array = data_fill($array, 'products.desk.discount', 10); // 無いのが分かっているなら、data_set()
        return Arr::dot($array); // 「ドット」記法で深さを表した一次元配列に変換
    }

    public function _str(){
        $string = 'The event will take place between :start and :end';
        $replaced = preg_replace_array('/:[a-z_]+/', ['8:30', '9:00'], $string);

        $string2 = 'The event will take place between ? and ?';
        $replaced2 = Str::replaceArray('?', ['8:30', '9:00'], $string);

        $slice = Str::between('This is my name', 'This', 'name'); // is my
        $camel = Str::camel('foo_bar'); // fooBar
        $snake = Str::snake('fooBar'); // foo_bar
        $kebab = Str::kebab('fooBar'); // foo-bar
        $studly = Str::studly('foo_bar'); // FooBar

        $adjusted = Str::start('this/string', '/'); // /this/string
        $adjusted = Str::finish('this/string', '/'); // this/string/
        $matches = Str::is('foo*', 'foobar'); // true
        $matches = Str::is('bar*', 'foobar'); // false

        // return (string) Str::orderedUuid(); // 「タイムスタンプ先行」のUUIDを生成
        $plural = Str::plural('datum'); // data

        $slug = Str::slug('Laravel 5 Framework', '-'); // laravel-5-framework

        $words = Str::words('Perfectly balanced, as all things should be.', 3, ' >>>'); // Perfectly balanced, as >>>

        # fluent
        $result = Str::of('foo bar baz')->explode(' ');

        return $result;
    }
    public function _url(){
        $url = action('FileController@show'); // "http://localhost/file/show"
        $url = url('user/profile'); // "http://localhost/user/profile"
        return $url;
    }
    public function _other(){
        /*
         *  blank(''); <-> filled()
            blank('   ');
            blank(null);
            blank(collect());
            // true

            blank(0);
            blank(true);
            blank(false);
            // false
         * */

        // すべての親で使われているものも含め、クラス中で使用されているトレイトをすべて返す。
        $traits = class_uses_recursive(\App\Models\User::class);
        // トレイトのみ
        $traits = trait_uses_recursive(\Illuminate\Notifications\Notifiable::class);

        //dot 記法
        $value = config('app.timezone'); // "UTC"

        $env = env('APP_ENV'); // "local"

        $bool = true;
        $myStr = 'kebab-str';
        $immediate_af = value(function() use($bool, $myStr) { // value(tree) => true
            if($bool) return Str::camel($myStr); // "kebabStr"
            else return Str::studly($myStr); // "KebabStr"
        });

        $callback = function($v){
            return(is_numeric($v)) ? $v * 2: 0;
        };
        $result = with(5, $callback);

        return $result;

    }
}

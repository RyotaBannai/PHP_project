### Login
- `login` and `logout` are not optional; only `register`, `reset`, `confirm`, and `verify` are optional. You would need to replace `Auth::routes()` with the individual roure definitions it provides in order to replace login.
```php
Auth::routes(['login' => false, 'register' => false]);
Route::get('user_register')->name('register')->uses('Auth\RegisterController@showRegistrationForm');
Route::get('user_login')->name('login')->uses('Auth\LoginController@showLoginForm');
```
#### ガードの指定
- authミドルウェアをルートに対し指定するときに、そのユーザーに対し認証を実行するガードを指定することもできる。指定されたガードは、`auth.php`設定ファイルのguards配列のキーを指定。
- `api.php`のAPIのルート設定でもガードを使っている。
```php
public function __construct()
{
  $this->middleware('auth:api');
}
```
#### pass の確認: 支払い設定、オーダーのキャンセル、クレジットカードの支払い履歴の確認時など
- `password.confirm` 指定したルートはパスワード各員のスクリーンへリダイレクトされ、続けるには入力する必要がある。
```php
Route::get('/settings/security', function () {
    // ユーザーは続けるためにパスワードの入力が必要
})->middleware(['auth', 'password.confirm']);
```
- 自前でlogin を実装したいなら次の様にする
```php
public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        }
    }
```
- リダイレクタの`intended`メソッドは、認証フィルターで引っかかる前にアクセスしようとしていたURLへ、ユーザーをリダイレクト。そのリダイレクトが不可能な場合の移動先として、フォールバックURIをこのメソッドに指定.
- エラーメッセージをbladeに送る手法
1: カスタムのエラ〜メッセージを作る用のクラス 
2: 追加するエラーを変数付きで宣言
3: withErrors で返す
4: message を使う
```php
LoginController.php
use Illuminate\Support\MessageBag; ---1
$message_bag->add('error', 'This is the error message'); ---2
return redirect('login')->withInput($request->input())->withErrors($message_bag); ---3

login.blade.php
@error('error') {{ $message }} @enderror ---4
```
- 2つ目
1: sessionにエラーメッセージも追加するパターン
2: sessionヘルパ関数から採取する
```php
LoginController.php
return redirect('login')->withInput($request->input())->with(['message'=>'Wrong username/password combination']); ---1

login.blade.php
@if(session()->has('message')) {{ session()->get( 'message' )}} @endif ---2
```
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
- 
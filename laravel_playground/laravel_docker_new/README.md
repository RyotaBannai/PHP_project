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
#### Pass の確認: 支払い設定、オーダーのキャンセル、クレジットカードの支払い履歴の確認時など
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
#### エラーメッセージをbladeに送る手法
##### 1つ目
1. カスタムのエラ〜メッセージを作る用のクラス 
2. 追加するエラーを変数付きで宣言
3. withErrors で返す
4. message を使う
```php
LoginController.php
use Illuminate\Support\MessageBag; ---1
$message_bag->add('error', 'This is the error message'); ---2
return redirect('login')->withInput($request->input())->withErrors($message_bag); ---3

login.blade.php
@error('error') {{ $message }} @enderror ---4
```
$message 以外の変数を使いたいとき
1. withErrors にkeyを渡す
2. $errors からkeyを使う. first（'error'）はカスタムでadd したので初めに追加したerror (= **Named Error Bags**)
```php
return redirect('login')->withInput($request->input())->withErrors($message_bag, 'login'); 

{{ $error->login->first('error')}}
```
##### 2つ目
1. sessionにエラーメッセージも追加するパターン
2. sessionヘルパ関数から採取する
```php
LoginController.php
return redirect('login')->withInput($request->input())->with(['message'=>'Wrong username/password combination']); ---1

login.blade.php
@if(session()->has('message')) {{ session()->get( 'message' )}} @endif ---2
```

### Guard
- The Auth facade uses the 'web' guard by default if none is specified. So for example: Auth::user() is doing this by default: Auth::guard('web')->user()
- The other auth driver out of the box called 'api'. So for example you can call your middleware like this: $this->middleware('auth:api'); This will check that the user is authenticated by api_token instead of session. You would use this if your application has an API endpoint allowed for logged in users only. then a user can make a request like yourapp.com/api-method?api_token=blahblah.
```php
Auth::guest()  // is a opposit of Auth:check()
Auth::check() 
```
- 組み込みLoginControllerを使用する場合、このコントローラが使用しているトレイトにより、"remember"ユーザーを確実に処理するロジックが実装済み
- ユーザーが`"remember me"クッキー`を使用して認証されているかを判定する
```php 
if (Auth::viaRemember()) { some codes }
```
#### ユーザーを一度だけ認証する
- `once`メソッドを使用すると、アプリケーションにユーザーをそのリクエストの間だけログインさせることができる。セッションもクッキーも使用しないため、ステートレスなAPIを構築する場合に便利。
```php
if (Auth::once($credentials)) {
}
```
- `http基本認証 -> auth.basic` 
```php
Route::get('profile', function() {
    // 認証済みのユーザーのみが入れる
})->middleware('auth.basic');
``` 
####  他のデバイス上のセッションを無効化
```php
use Illuminate\Support\Facades\Auth;
Auth::logoutOtherDevices($password);
```
- loginルートに対するルート名をカスタマイズしながら、AuthenticateSessionミドルウェアを使用している場合は、アプリケーションの例外ハンドラにあるunauthenticatedメソッドをオーバーライドし、ログインページへユーザーを確実にリダイレクトさせる。loginルートはデフォルトで実装されてる.
### Policy
- **ポリシーの登録**: 指定したモデルに対するアクションの認可時に、どのポリシーを利用するかをLaravelへ指定すること
- ポリシーの名前は対応するモデルの名前へ、Policyサフィックスを付けたものにする必要がある。Userモデルに対応させるには、`UserPolicy`クラスと命名.
- `AuthServiceProvider`中で明確にマップされたポリシーは、自動検出される可能性のあるポリシーよりも優先的に扱われる。
- ポリシーから認可レスポンスを返す場合、`Gate::allows`メソッドはシンプルな論理値を返す。しかし、ゲートから完全な認可レスポンスを取得するには、`Gate::inspect`メソッドを使用。 Gate は認証でPolicy は認可。
- HTTPリクエストが認証済みユーザーにより開始されたものでなければ（つまりゲストユーザーの場合）、すべてのゲートとポリシーは自動的にデフォルトとして`false`を返す。しかし、**「オプショナル」** なタイプヒントを宣言するか、ユーザーの引数宣言に`null`デフォルトバリューを指定することで、ゲートやポリシーに対する認可チェックをパスさせることができる。
```php
public function update(?User $user, Post $post) // $user = null
    {
        return optional($user)->id === $post->user_id;
    }
```
- 指定するモデルのポリシーが登録済みであれば適切なポリシーの`can`メソッドが自動的に呼びだされ、論理型の結果が返される。そのモデルに対するポリシーが登録されて**いない**場合、`can`メソッドは指定したアクション名に合致する、**ゲートベースのクロージャ**を呼ぶ。
```php
if ($user->can('update', $post)) { 
    //
}
```
- モデルを必要としないアクションの場合は、`モデルのクラス名`を渡す。これでどのモデルのupdateのPolicyかを識別できる。
```php
if ($user->can('update', Post::class)) { 
    //
}
```
- policyに引数を渡すときは配列で渡す
```php
public function update(Request $request, Post $post)
{
    $this->authorize('update', [$post, $request->input('category')]);

    // 現在のユーザーは、このブログポストを更新できる…
}

```
- 認可はmiddleware, Controller ($this->authorize())  にも実装できる。
### 認証系
- users のremember_token はtokenの情報がリセット用のURLに添付され、リセット者を特定する。URLのリンクの有効期限も管理。
- password_reset table: 有効期限は、`config/auth.phpのpasswords`の中で`expire => 60`（60分）と定義
###メール
- `php artisan vendor:publish --tag=laravel-mail`で`resources/views/vendor/mail`ディレクトリ下に、Markdownメールコンポーネントがリソース公開される。これを編集すればカスタムテンプレテートが作れる。
- markdownの形式のテンプレート変えたいときは、`config/mail.php`でcssを変更
- Let user to submit Markdown, and app display it as HTML.
```php
public static function getTextAttribute($value)
{
    return new HtmlString(
        app(Parsedown::class)->setSafeMode(true)->text($text)
    );
}
```
- `safeMode()` that “sanitizes” the output HTML. [find here info](https://medium.com/@DarkGhostHunter/laravel-there-is-a-markdown-parser-and-you-dont-know-it-5f523e22121e)
- Combine with [`Purifier`](https://github.com/stevebauman/purify) to clean what comes out if you want to be 100% sure what is displayed doesn't break your site, or doesn't **inject scripts**. For instance, Purifier remove `<script>` code.

```php
public function getTextAttribute($value)
{
    // Hash the text with the lowest computational hasher available.
    $key = 'article|'.$this->id.'|'.hash(MHASH_ADLER32, $value);
    // If the cache with this hash exists, return it, otherwise
    // parse it again and save it into the cache for 1 day.       
    return Cache::remember($key, 86400, function () use ($value) {
        return $this->parseMarkdownToHtml($text);
    })
}

protected function parseMarkdownToHtml(string $text)
{
    return new HtmlString(app(Parsedown::class)->text($text));
}
- other parse method: `[cebe/markdown]`(https://github.com/cebe/markdown)
- `to()` methodにはユーザーオブジェクトをそのまま渡せる
```php
    public function ship(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        // 配送処理…
        Mail::to($request->user())->send(new OrderShipped($order));
    }
```
- 実際には送信しないが、MailableのHTMLコンテンツを利用したいときは`render()`メソッドを使用
- デザイン時など、Mailablesをブラウザでプレビューしたいときは、ルートのクロージャやコントローラから直接mailableを返すことができる`return new App\Mail\InvoicePaid($invoice);`
- メールのメッセージに時間がかかるので普通は`queue()`を使ってバックグラウンドで送信する。
- queue を使う前にqueueの設定を行う必要がる。queueのた目のダッシュボードHorizonを使うと良い.
- ユーザーの希望するローケルをアプリケーションで保存しておくことは良くあります。モデルで`HasLocalePreference`契約を実装すると、メール送信時にこの保存してあるローケルを使用するように、Laravelへ指示できます。このインターフェイスを使用する場合、localeメソッドを呼び出す必要はありません。
- 開発環境でメールを実際のユーザーに送らずに動作を確認する方法
1. メールを送信する代わりに、logメールドライバで、すべてのメールメッセージを確認のためにログファイルへ書き込こむ。
2. `config/mail.php` の to の設定を変更して全てのメールを送信する先を変更する。
3. 最後の方法はMailtrapのようなサービスを使い、smtpドライバで本当のメールクライアントにより内容を確認できる「ダミー」のメールボックスへメールメッセージを送る方法
### Go find learn list
- https://laraveldaily.teachable.com/p/export-import-with-excel-in-laravel
- https://readouble.com/laravel/7.x/ja/queues.html
### cleaing cache
- try runnning all these commands
```shell script
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```
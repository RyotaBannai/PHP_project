### Sanctum
- 一つのデータベーステーブルへユーザーのAPIトークンを保存しておき、受信したリクエストが**Authorizationヘッダに有効なAPIトークンを含んでいるかにより**認証
- Sanctumはトークンは一切使用**しません**。代わりにLaravelへ組み込まれてい**るクッキーベースのセッション認証サービス**を使用します。これにより、XSSによる認証情報リークに対する保護と同時に、CSRF保護・セッションの認証を提供しています。皆さんのSPAのフロントエンドから送信されるリクエストに対し、Sanctumは**クッキーだけを使用して**認証を確立します。
- APIリクエスト認証に使用するため、`APIトークン／パーソナルアクセストークン`をSanctumは発行します。`APIトークンを利用するリクエストを作成する`場合は、`Bearerトークン`として`Authorizationヘッダにトークンを含める`必要があります。
- ユーザーにトークンを発行開始するには、Userモデルで`HasApiTokensトレイト`を使用してください。
```php
$token = $user->createToken('token-name');
return $token->plainTextToken;
```
- ルート保護: 受信リクエストを`すべて認証済みに限定`し、ルートを保護する場合は、`routes/api.php`ファイル中のAPIルートに対してsanctum認証ガードを指定する必要があります。このガードは受信リクエストが認証済みであると保証します。そのリクエストが皆さん自身の`SPAからのステートフルな認証済み`であるか、もしくは`サードパーティからのリクエストの場合は有効なAPIトークンのヘッダを持っているか`のどちらか一方であるか確認します。
```php
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
```
- ログインリクエストに成功するとユーザーは認証され、Laravelのバックエンドがクライアントへ発行しているセッションクッキーにより、APIルートに対する以降のリクエストも自動的に認証されます.s
### Sanctum vs Passport
- `Passport` provides a full `OAuth2` server implementation for your Laravel application in a matter of minutes. It is therefore necessary to have a brief knowledge of OAuth2.
- `Sanctum` is a simple package to issue `API tokens` to your users without the complication of OAuth. `Sanctum` uses Laravel's built-in **cookie based session authentication services**. In a small application use Sanctum. it's simple and easy.
- `Tokens` are a flexible way to authenticate, but you need to worry about `**where on the client side you want to securely store that token**`. Specially if the client is a JS application. On the other hand, `sessions` are **stored on the server side so they are more safe**. However, you need to worry about **the storage size** and the fact that **it's only available to applications running on the same root domain**.
- Before authenticating the user, you need to make a GET request to `/sanctum/csrf-cookie`. The response will include the `XSRF-TOKEN cookie`which will be stored in your browser and used by your HTTP client (e.g. axios) in future requests. Laravel will read **the token** attached to the request headers and `compare it with the token stored in your session`.
- `config/cors.php` `'supports_credentials' => true`: instructs Laravel to send the `Access-Control-Allow-Credentials` header in every response, this will make **browsers share the cookies** sent with the JavaScript app running.
- You can use `Sanctum` instead of `passport` if your application doesn't need `the Client Credential grant to allow machine-to-machine communication or the Authorization Code grant`. These types of communication require more advanced authentication techniques that `Sanctum` is not built to handle.
- [reference](https://divinglaravel.com/authentication-and-laravel-airlock)
### Passport
- [OAUTH Terminology](https://oauth2.thephpleague.com/terminology/)

|Terminology|Definition|
|:------| :------- |
|Access token|A token used to access protected resources|
|Authorization code|`An intermediary token` generated when a **user authorizes a client to access protected resources on their behalf**. The client receives this token and exchanges it for `an access token`.| 
|Authorization server|A server which `issues access tokens` after successfully authenticating a client and resource owner, and authorizing the request.|
|Client|`An application` which accesses protected resources on behalf of the resource owner (such as a user). The client could be hosted on a server, desktop, mobile or other device.|
|Grant|A grant is a method of `acquiring an access token`.|
|Resource server|A server which `sits in front of protected resources` (for example “tweets”, users’ photos, or personal data) and is capable of accepting and responding to protected resource requests `using access tokens`.|
|Resource owner|`The user` who authorizes an application to access their account. The application’s access to the user’s account is **limited to the** “`scope`” of the authorization granted (e.g. read or write access).|
|Scope|A permission.|
|JWT|`A JSON Web Token` is a method for representing claims securely between two parties as defined in RFC 7519.|

- Passportのマイグレーションは、アプリケーションで必要となる、`クライアント`と`アクセストークン`を保存しておくテーブルを作成します。
```
php artisan migrate
```
- 次に `php artisan passport:install` を実行。このコマンドは**安全なアクセストークンを生成するのに必要な暗号キーを作成**します。さらにアクセストークンを生成するために使用する、`「パーソナルアクセス」クライアント`と`「パスワードグラント」クライアント`も作成します。
```
Encryption keys generated successfully.
Personal access client created successfully.
Client ID: 1
Client secret: 1AiLA25C3gWEWfp2lPuR5kFZwMDCxWrIrDF3kEDh
Password grant client created successfully.
Client ID: 2
Client secret: AtyCIYLmJiBpQL2gZPxGo76SvYsoxxwR9NUD0Tii
```
- `php artisan vendor:publish --tag=passport-components` passport vue components.
- `http\Kernel.php` の`middleware` に　`\Laravel\Passport\Http\Middleware\CreateFreshApiToken::class`を追加することで、jwt `personal access token`無しでapiアクセスできる。
- access tokenの作成はvue publishで生成できるcomponentsを使ってもできるが、Json APIを使って作成もできる。
```javascript
// token取得のための一番最初の認証
const data = {
    name: 'Client Name',
    redirect: 'http://example.com/callback'
};
axios.post('/oauth/clients', data)
    .then(response => {
        console.log(response.data);
    });

// 更新時には client idも渡す
axios.put('/oauth/clients/' + clientId, data)
    .then(response => {
        console.log(response.data);
    })
```

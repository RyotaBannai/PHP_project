### chachファサードとredis ファサード

- **Cacheファサード**:キャッシュを扱う際にどの方式（ファイルでもDBでもNoSQLでも）を採用しても共通して使えるメソッド。
- 一方、RedisファサードはRedis操作のためのクラスであり、Redisコマンドの全てをコールする事ができる。

### DI: Dependency Injection: 依存性の注入 = 依存している部分を、外から注入すること.
- Laravelでは、DI コンテナな（サービスコンテナ）を中心としてフレームワークが作られている.
- DI の方法は以下の3つ：
    1. メソッド・インジェクション
    2. セッタ・インジェクション
    3. コンストラクタ・インジェクション
1. **メソッドの引数に依存対象のクラスを渡すこと**：
```php
<?php 
class Dog{
    public function run(Cat $cat){ // ここでクラスをインスタンス化する
        $cat->run();
    }
}
$myDog = new Dog();
$myDog->run();
```
2. DI用のセッタを用意し依存対象のクラスを渡すこと：
```php
<?php
class Dog{
    private $cat; // セッタのための変数
    public function setCat(Cat $cat){ // セッタ
        $this->cat = $cat;
    }
    public function run(Cat $cat){ // ここでクラスをインスタンス化する
        $this->cat->run();
    }
}
$myDog = new Dog();
$myCat = new Cat(); // ここで余分な行がでる. 
$myDog->setCat($myCat); // ここで余分な行がでる. 
$myDog->run(); 
```
3. コンストラクタに依存対象のクラスを渡すこと：
```php
<?php
class Dog{
    private $cat; // コンストラクタのための変数
    public function __construct(Cat $cat){ // コンストラクタ
        $this->cat = $cat;
    }
    public function run(Cat $cat){ // ここでクラスをインスタンス化する
        $this->cat->run();
    }
}
$myCat = new Cat(); // ここで余分な行がでる. 
$myDog = new Dog($myCat); 
$myDog->run(); 
```
- 参考: https://laraweb.net/surrounding/2001/

### DIコンテナ
- コンストラクタインジェクションを使って実装.
- DIのデメリット:
    1. 注入したいオブジェクトが多いとその分引数が多くなること.
    2. 使用する時に毎回同じ操作をしなければならないこと.
-> DIの設定を管理するべき: 「DIコンテナ」という概念を利用 = クラスのインスタンスを一括で済むようにしたもの
- DIコンテナは次の２つを一元化管理する:
    1. 依存性の注入
    2. インスタンスの生成
- DIコンテナを利用するためのライブラリ:
    1. PHP-DI
    2. Pimple
- 参照 https://laraweb.net/surrounding/2018/

### サービスコンテナ: クラス（サービス）のインスタンス化を管理する仕組み
- サービスコンテナにインスタンス生成方法を結び付けて利用. (バインド と呼ぶ)
- 処理のステップ:
    1. サービスコンテナにクラスを登録：バインド (これがDIコンテナで言う $containerに追加していくとこの概念.)
    2. サービスコンテナからクラスを生成：リゾルブ (クラスのインスタンスは一回でokと言う概念.)
```php
$this->app->bind('sender', 'MailSender');
```
- `$this->app` が**サービスコンテナ**である.
- サービスコンテナ（$this-app）に bind()メソッド でクラス（MailSender）を登録.
- 第一引数にキー名（sender）、第二引数にクラス名（MailSender）入れて紐付けして登録. ($container['sender'] = new MailSender();とやっていた部分.)
```php
$this->app->make('sender');
```
- サービスコンテナ（$this->app）からキー名（sender）に対応するクラスを生成.
- このケースでは MailSender のインスタンスが返ってくる. リゾルブ完結.
- 参照 https://laraweb.net/practice/2029/
### サービスプロバイダー = Laravelはサービス毎に初期処理を定義し、実行する仕組みを持っており、この初期処理の実装を行うクラスのこと
- サービスコンテナのbindの処理を請け負う.
- サービスプロバイダーが行うことは３つ:
    1. サービスコンテナへのバインド
    2. イベントリスナーやミドルウェア、ルーティングの登録
    3. 外部コンポーネントを組み込む
- まずは次のコマンドでサービスプロバイダーを作成する. `php artisan make:provider UtilServiceProvier` これで app\Providers 配下に新しいプロバイダーが作成される.
- サービスプロバイダーをconfig/app.phpに登録.
- this is a good one to understand what provider bind for. https://code.tutsplus.com/tutorials/how-to-register-use-laravel-service-providers--cms-28966
- https://stackoverflow.com/questions/31685073/laravel-5-1-service-container-binding-using-something-other-than-the-class-name
- https://reffect.co.jp/laravel/laravel-service-provider-understand
- この説明がすごいわかりやすい. https://qiita.com/dublog/items/3314ca25a90e76f63b17
```php
# ex.1
class Walk 
{
    private $dog;
    public function __construct()
    {
        $this->dog = new Dog();
    }
}
# ex.2
class Walk
{
    private $dog;
    public function __construct(Dog $dog){
        $this->dog = $dog;
    }
}
```
- 違いはコンストラクタ内でnewを使っているか、コンストラクタの引数にDog型の引数を渡しているか。
- この違いはWalk(散歩クラス)のDogへの依存度に差を生む。
- ex.1はDogクラスの犬しか散歩させることがで機内が、ex.2はDogだけでなくDogクラスを継承したLabやDachshundをインスタンス生成時に指定することでWalkクラスを用いて散歩させることができる。つまり、**Walkクラスの操作対象がDogに限定されていたものが、外部から指定可能になった。** これが依存度が下がったという意味である。これを「依存を外部から注入する」と言う理由の仕組みである.
- サービスプロバイダでコードを管理することで良いこと：
    1. テスト時にはアプリケーションコードで生成されるインスタンスをテスト用にすり替えるといったことができる
    2. あるインスタンスはアプリケーション実行プロセスで一つだけ（シングルトン）にしたいので、2回目の生成時には前回生成したインスタンスを返す
- 確かにこれが連鎖的に発生してしまう可能性はあり：
```php
class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserController::class, function($app) {
            return new \App\Http\Controllers\UserController($app->make(UserRegistry::class)); // ここが連鎖になる可能性あり
        });
    }
}
```
- 参照 https://qiita.com/kunit/items/adee0a6aa449d53602c0
- https://qiita.com/kd9951/items/2328e2f8add9037bd990
- Contextual binding with service provider:
- https://stackoverflow.com/questions/52777570/laravel-5-how-to-use-this-app-when
```php
$this->app->extend(Service::class, function($service) {
    return new DecoratedService($service);
});
```
- this is like the same implementation of Python's decorator.
### Facade ファサード: なるべくロジックの記述を奥にしまいこんで、簡潔にクラスのメソッドを呼び出すようにするのがファサードの役割
- Laravelでは標準で37種類のファサードが提供されてる.
- Request:: やRoute:: などLaravelに標準で搭載されているお馴染みのファサード.
- `vendor\laravel\framework\src\Illuminate\Support\Facades\Request.php` に置かれている.
- `Config`: config/app.phpの値を取得. `Log`: ログの書き出しなど. storage/logsなどに書き出せるのでデバックなどで重宝する.
- Facadeを使えるようにするまでの手順:
1. `App\Providers`にService Providerを作成. hit the following command `php artisan make:provider ${ANY}ServiceProvider`
2. `App\Services`に独自のクラスを作成し、ファサードとして利用したいロジックを作成.
3. Service Providerの中で `\App\Services`に作成したロジックをbind.
4. `App\Facades`に独自のファサードとして使えるようにするためのロジックを書くためのファイルを作成（フォルダがなければ作成）
5. `App\Facades`で作成したファイルに`use Illuminate\Support\Facades\Facade;`をしてこれを拡張する. サブクラスに`protected static function getFacadeAccessor()`メソッドを作成し、このメソッド内で**3**でbindしたキーをreturn.
6. `config\app.php`に**3**のService Providerを登録　
7. `config\app.php`に**4,5**のファサードを登録
- こうすることでバックエンド側を意識せずに、コントローラーやbladeで使用する複雑なロジックの再利用性をあげたり、ボリューミーなコードを分割して管理することができる.
- **尚**、DBを操作するときはファサードではなくモデルに記述する.　ファサードはその文字通りフロントエンドで使用すると言う意図を含む.
- 参照 https://laraweb.net/practice/6073/
- https://laraweb.net/practice/2065/
- DIだと明確に呼び出さないといけないが、ファサードを使用すれば使いたい場所でそのままスタティックメソッドを呼び出せば良い.これをリアルタイムファサードと呼ぶ.
### ファサードを注意点
- ファサードはとても簡単に使用でき依存注入も必要ないため、簡単にクラスが成長し続ける結果、一つのクラスで多くのファサードが使われる.
- ファサードを使用するときは、クラスの責任範囲を小さくとどめるため、**クラスサイズにとくに注意を払う**.
- 「契約 Vs. ファサード」：https://readouble.com/laravel/7.x/ja/contracts.html
- ファサード一覧: https://readouble.com/laravel/7.x/ja/facades.html
### ヘルパ関数
- `cache('key)` とか `view('profile')`のような関数.
### 共通関数・汎用関数：ファサードまでは大袈裟にやりたくないが、同じ処理を複数の関数で使いまわしたい場合に利用.
- 共通関数を作成する手順:
1. `app\Library`に作成したいクラスを作成. 無ければ作成.　（`namespace`の記述を忘れない...）
2.　`class map`を作成しないといけないため, `composer.json`に登録し、`composer dump-autoload`を実行.
```php
"autoload": {
        "classmap": [
            "database/seeds",
            "database/factories",
            "app/Library" // 追加
        ]
    },
```
3. `config\app.php`にエイリアスを作成. (任意)
4. 使いたい時に`use`で呼び込む.
- 参照 https://qol-kk.com/wp2/blog/2019/04/01/post-1183/
### Difference bw composer dump-autoload and php artisan dump-autoload
https://lavalite.org/blog/differences-between-php-artisan-dump-autoload-and-composer-dump-autoload
### Query Builder
- 参照 https://readouble.com/laravel/5.5/ja/queries.html
### Migration, マイグレーション：データベースのバージョンコントロールのような機能.
- **アプリケーションデータベースのスキーマの更新をチームで簡単に共有できるようにする.**
- もし今まで、チームメイトに彼らのローカルデータベーススキーマに手作業でカラムを追加するよう依頼したことがあるなら、データベースマイグレーションは、そうした問題を解決する.
- `php artisan make:migration create_flights_table` `create_XXXX_table` XXXXの部分をテーブル名にする.
- `php artisan migrate:rollback`で最後のmigrationを元に戻す= テーブルを消去. `php artisan migrate:rollback --step=5`で最後の5マイグレーションをロールバック. `php artisan migrate:reset` で全てのマイグレーションをロールバック.
- 特定のテーブルに対して実行したい場合はパスも指定する`php artisan migrate:refresh  --path=/database/migrations/2014_10_12_000000_create_users_table.php`
- データベースをリフレッシュしたい.. `php artisan migrage:refresh`-> 全てロールバックして、全てマイグレーションする.  `php artisan migrage:refresh --seed`-> シードも加える. **refreshはfresh(drop)とは別の概念.**
- **外部キー制約** `$table->foreign('user_id')->references('id')->on('users')` この場合、`company` tableの`user_id` に`users` tableの`id`をリンクさせる. さらに束縛に対して、on Deleteやon Updateに対する処理をオプションとして指定できる. `onDelete('cascade')`で`id`が消去された時に、`company`のレコードも消去される. 消去したく無ければ、null を指定。デフォルトはrestrictまたはnoactionで削除アクションは拒否される.
- 参考 https://stackoverflow.com/questions/6720050/foreign-key-constraints-when-to-use-on-update-and-on-delete
- https://www.mysqltutorial.org/mysql-on-delete-cascade/
- Laravel docs: https://readouble.com/laravel/5.5/ja/migrations.html
### composer.json, autoload
- 記述方式は 、"名前空間プレフィクス\\" : "対応するベースディレクトリ" となる。
- 例えば、 namespace Controllers と宣言されたクラスは、app/controllers/の中にありますよ、と設定してあげている状態。
- composer.json書き終えたら、`composer dump-autoload` をする.(必須)
```php
{
    "autoload": {
        "psr-4": {
            "Controllers\\" : "app/controllers/",
        }
    }
}
```
- 実際に使う時は以下の様な感じ. App\から始める必要無かったり便利.
```php
use Controller\MyController
```
- 参考 https://qiita.com/yotsak83/items/cc1a4936c0c92099db5a
### アクティブレコード (Active record, Active record pattern) = CRUD(4つのデータベース操作を表す「Create」「Read」「Update」「Delete」の頭字語) Active Recordはこれらのメソッドを自動的に作成する.
- Rails発祥のアイディアだがLaravelのEloquentにも適用されている.
- Add a new model file in `app\Models` by hitting `php artisan make:model Models\\Ingredient` **クラス名は単数形にすること**.
- モデルにどのテーブルを使用するか、Eloquentに指定していない点に注目。他の名前を明示的に指定しない限り、クラス名を複数形の「スネークケース」にしたものが、テーブル名として使用される.
- Modeleで作ったメソッドは、Controller内で直接呼び出すと言うよりかは、all() で取ってきた全データに対してメソッドを使う、 と言う考え方.
- そのため、foreachでは連想配列で添字を使用して各要素を呼び出している訳じゃなく、各インスタンスのプロパティを取得していると言う訳なのである.
- docker環境でSeedを使うときは一回中に入らないと、dbにアクセスできないの注意.(homestead使っている時など) `docker-compose exec app bash`, `php artisan db:seed --class=UsersTableSeeder`
- データベースをからにする場合 `php artisan migrate:refresh` からにしてシードを入れる場合 `php artisan migrate:refresh --seed`
- 参照 https://qiita.com/yukibe/items/f18c946105c89c37389d
### Eloquent ORM 
- ORM作成時にマイグレーションも作成したい場合`php artisan make:model User --migration (or -m)`
- Eloquentは更にテーブルの主キーがidというカラム名であると想定。この規約をオーバーライドする場合は、**protectedのprimaryKeyプロパティ**を定義
- 主キーに関しては色々と制約があるため、気を付ける. int, autoincrementでない場合等. 
- Eloquentモデルはデフォルトでアプリケーションに設定されているデフォルトのデータベース接続を利用. モデルで異なった接続をしたい場合は、**$connectionプロパティ**を使用.
- 複数の結果を取得するallやgetのようなEloquentメソッドは、Illuminate\Database\Eloquent\Collectionインスタンスを返す。CollectionクラスはEloquent結果を操作する多くの便利なクラスを提供している。つまり、query builderで使える様な関数をEloquentdでも使えると言うこと.
- `::find`メソッドは主キーと一致したレコードを返す.
- `::where('active', 1)->count()`とかで集計ができる
- ソフトデリート（論理消去）をやるには、`Illuminate\Database\Eloquent\SoftDeletes`トレイトを使い、`deleted_at`カラムを`$dates`プロパティに追加.`softDeletes()`を使い、実際にソフトデリートされたかどうか確認するには `trashed()`. ソフトデリートしたモデルは自動的にクエリの結果から除外される.なので取得したい時は、`withTrashed()`.
- all() などのグローバルスコープの挙動を変えたい時は、`Illuminate\Database\Eloquent\Scope`インターフェイスを実装したクラスを定義し,apply()にwhere を書く. overwriteすることになるため、selectは使用してはならない。それから、modelでboot()、その中でparent::boot();static::addGlobalScope(new YourNewScope);` を記述.
- Eloquentではイベントを発行できる。creaitng, updating, deleting等. これ利用してリアルタイムの投票結果システムなど構築できる.
### Eloquent ORM リレーション
- User テーブルクラスで hasOne('Models\Phone')を定義し、User::find(1)->phone;とする-> 初めにユーザーid, ここではuser_idがphone テーブルにあると仮定して、その情報を取得するリレーションを作成することができる.
```php
class User extends Model
{
    public function phone()
    {
        return $this->hasOne('App\Phone');
    }
}
----
$phone = User::find(1)->phone; // 1vs 1　
```
- 何が嬉しいか: phone テーブルを触らなくていい = user テーブルだけ使える
- 逆の関係の定義では`belongTo('App\User')`を使う. _idのサフィックスとテーブル名と一致するidを探す。ここでは Userなのでuser_idとUserテーブルのidをみる. user が存在しない時の処理は `withDefault()`
- 1 vs 多数の場合　twitterなどの場合は `hasMany()`
- i vs 多数（Inverse）の場合　記事のブックマークやいいね！の梅は`belong**s**To()`
- 多数 vs 多数　の場合　ユーザーのロール. `belongsToMany()` で３つテーブルが必要. users とroles とrole_user(中間テーブル). このuser_roleにはuser_id, role_idが含まれている必要がある. `belongsToMany('Models\Role, 'role_user', 'user_id', 'role_id')` がdefault.
### has many through 
- 一つのテーブル経由で複数のレコードを取得.
### ポリモーフィック関係
- リレーションは一つの関係で、複数のモデルに所属させたい時.
### 多対多ポリモーフィック関係
- 多対多 + ポリモーフィック. 例えば、動画、記事などの複数のコンテンツに対するタグ. 動画、記事という複数のテーブルに対してポリモーフィックにし、そのコンテンツに複数のタグレコードが関連する場合.
### リレーションメソッド 対 動的プロパティ
- 取得したコレクションにプロパティにアクセスしたときに実際にデータをロードする（遅延ロード）。これだとパフォーマンスが悪いため、Eagerローディングで事前に全てロードしておくと良い. (都度ロードするということはN+1問題だということ)
- ::with('author)->get()を使用.
### 遅延Eagerローディング
- all()で読み込んだ後に、laod()を使う.
```pho
$books = Models\Book::all();
$books->load('author');
```
- 参照 https://readouble.com/laravel/5.5/ja/eloquent-relationship.html
### 変数受け渡し方法
- https://qiita.com/ryo2132/items/63ced19601b3fa30e6de
### Eloquent コレクション
- ほとんどのEloquentコレクションは新しいEloquentコレクションのインスタンスを返す(`Illuminate\Database\Eloquent\Collection`)が、pluck、keys、zip、collapse、flatten、flipメソッドはベースのコレクションインスタンスを返す(`Illuminate\Support\Collection`)。Eloquentモデルをまったく含まないコレクションを返すmap操作のような場合、自動的にベースコレクションへキャストされる。
### Blade
- https://www.larashout.com/12-awesome-laravel-blade-directives-to-try-today
- @include は親blade　から子bladeに後から変数を渡したい時に使う。header componentにタイトル名を渡す時とか。
- @eachならormからコレクションをそのままviewに変数を渡したい場合に便利。
### Blade component 
- Blade's `@include` directive allows you to include a Blade view from within another view. All variables that are available to the parent view will be made available to the included view!
```blade
@include('shared.errors')
```
- Even though the included view will inherit all data available in the parent view, you may also pass an array of extra data to the included view.
```blade
@include('view.name', ['some' => 'data'])
```
- If you attempt to @include a view which does not exist, Laravel will throw an error. If you would like to include a view that may or may not be present, you should use the @includeIf directive.
```blade
@includeIf('view.name', ['some' => 'data'])
```
### 署名付きURL
- 名前付きルートに対し`署名URL`を作成するには、URLファサードの`signedRoute`メソッドを使用
- `署名付きルートリクエストの検査`では送信された`Request`に対して、`hasValidSignature`メソッドを呼ぶ。
- それかmiddlewareでやる.
```blade
Route::post('/unsubscribe/{user}', function (Request $request) {
    // ...
})->name('unsubscribe')->middleware('signed');
```
### Middleware 
-  `app\Providers\RouteServiceProvider`により、`routes/web.php`ファイルでは、webミドルウェアグループが自動的に適用されている。
- **handleとterminateメソッドの呼び出しで同一のミドルウェアインスタンスを使用したい場合**は、コンテナのsingletonメソッドを使用し、ミドルウェアを登録する。通常、`AppServiceProvider.php`のregisterメソッドの中で登録。

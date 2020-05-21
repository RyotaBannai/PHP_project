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
- **外部キー制約** `$table->foreign('user_id')->references('id')->on('users')` この場合、`company` tableの`user_id` に`users` tableの`id`をリンクさせる. さらに束縛に対して、on Deleteやon Updateに対する処理をオプションとして指定できる. `onDelete('cascade')`で`id`が消去された時に、`company`のレコードも消去される. 消去したく無ければ、null を指定。デフォルトはrestrictまたはno actionで削除アクションは拒否される.
- 参考 https://stackoverflow.com/questions/6720050/foreign-key-constraints-when-to-use-on-update-and-on-delete
- https://www.mysqltutorial.org/mysql-on-delete-cascade/
- Laravel docs: https://readouble.com/laravel/5.5/ja/migrations.html
- wipe command: `php artisan db:wipe` - `migrate:reset` command is very slow **on many migrations amount** because it iterates thru the migrations table and executes down method for each migration. But more importantly, `down` method could be missing if migrations designed to go only `up` or **there is no dropping foreign keys** in them. So now call `db:wipe`and then migrate.
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
- `Modele`で作ったメソッドは、Controller内で直接呼び出すと言うよりかは、`all()`で取ってきた全データに対してメソッドを使う、 と言う考え方.
- そのため、foreachでは連想配列で添字を使用して各要素を呼び出している訳じゃなく、`各インスタンスのプロパティを取得している`と言う訳なのである.
- docker環境でSeedを使うときは一回中に入らないと、dbにアクセスできないの注意.(homestead使っている時など) `docker-compose exec app bash`
- Seeder作成`php artisan make:seeder TagsTableSeeder` テーブル名を複数形にしてTableSeederと続ける。
- `php artisan db:seed`: DatabaseSeeder に書いたシード全部実行。`php artisan db:seed --class=UsersTableSeeder`：特定のシード実行
- `データベースをResetにする`: `php artisan migrate:refresh` `Reset`してシードを入れ直したい場合 `php artisan migrate:refresh --seed`
- `migrate:reset`: Rollback all database migrations. -> The better solution `migrate:wipe` drop all tables efficiently.
- `migrate:fresh` `Drop all tables` and `re-run all migrations`.
- 参照 https://qiita.com/yukibe/items/f18c946105c89c37389d
- **Migrationでカラム情報変更・消去**: カラムを変更する前に、composer.jsonファイルで`doctrine/dbal`を確実に追加する。`Doctrine DBAL`ライブラリーは`現在のカラムの状態を決め、指定されたカラムに対する修正を行うSQLクエリを生成する`ために使用される。
- ファクトリの中のクロージャでは評価済みのファクトリーの属性配列を受け取ることもできる。
```php
$factory->define(App\Post::class, function ($faker) {
    return [
        'title' => $faker->title,
        'content' => $faker->paragraph,
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'user_type' => function (array $post) {
            return App\User::find($post['user_id'])->type;
        }
    ];
});
- `Mass assignment` http://laravel.hatenablog.com/entry/2013/10/24/005050
- factory の `state`を使う。**特定のカラムだけ毎回同じ処理を適用する場合**に使用。
```php
$factory->state(App\User::class, 'address', function ($faker) {
    return [
        'address' => $faker->address,
    ];
});
$users = factory(App\User::class, 5)->states('address')->make();
// $users = factory(App\User::class, 5)->states('address', 'delinquent')->make(); // multiple states
```
- `defineAs vs state`: `defineAs` allows to crete specific seed data in a shorthand way, while `state` allows to factory to use specific value in all seed data.
```php
// ---- defineAs (Might be already obsoleted...)
$factory->defineAs(User::class, 'inactive', function (Faker\Generator $faker) {
    return [
         'username' => $faker->userName,
        'email' => $faker->email,
        'name' => $faker->name,
        'active' => 0
    ];
});
// or better way is... since you've already defined User factory with active = 1.
$factory->defineAs(User::class, 'in_active', function ($faker) use ($factory) {
    $users = $factory->raw(User::class);
    return array_merge($users, ['active' => 0]);
});
$factory->(User::class, 'in_active', 5)->create(); // create inactive 5 users 
```
```php
// ---- state
$factory->state(User::class, 'in_active', function ($faker) {
    return [
        'active' => 0,
    ];
});
// or
$factory->state(User::class, 'in_active', [
    'active' => 0,
});
$factory->(User::class, 5)->state('in_active')->create(); // create inactive 5 users 
```
- [Reference](https://stackoverflow.com/questions/49979511/in-laravel-factories-what-is-the-difference-from-state-and-defineas)
- [Good one as well - 1](https://laravel-news.com/learn-to-use-model-factories-in-laravel-5-1)
- [Good one as well - 2](https://scotch.io/tutorials/generate-dummy-laravel-data-with-model-factories)
### Laravel Create Project
- `composer create-project laravel/laravel [Project Name] --prefer-dist`
### Eloquent ORM 
- Model作成時にマイグレーションも作成したい場合`php artisan make:model User --migration (or -m)`
- Eloquentは更にテーブルの主キーがidというカラム名であると想定。この規約をオーバーライドする場合は、**protectedのprimaryKeyプロパティ**を定義
- 主キーに関しては色々と制約があるため、気を付ける. int, autoincrementでない場合等. 
- Eloquentモデルはデフォルトでアプリケーションに設定されているデフォルトのデータベース接続を利用. モデルで異なった接続をしたい場合は、**$connectionプロパティ**を使用.
- 複数の結果を取得するallやgetのようなEloquentメソッドは、Illuminate\Database\Eloquent\Collectionインスタンスを返す。CollectionクラスはEloquent結果を操作する多くの便利なクラスを提供している。つまり、query builderで使える様な関数をEloquentdでも使えると言うこと.
- `::find`メソッドは主キーと一致したレコードを返す.
- `::where('active', 1)->count()`とかで集計ができる
- ソフトデリート（論理消去）をやるには、`Illuminate\Database\Eloquent\SoftDeletes`トレイトを使い、`deleted_at`カラムを`$dates`プロパティに追加.`softDeletes()`を使い、実際にソフトデリートされたかどうか確認するには `trashed()`. ソフトデリートしたモデルは自動的にクエリの結果から除外される.なので取得したい時は、`withTrashed()`.
- all() などのグローバルスコープの挙動を変えたい時は、`Illuminate\Database\Eloquent\Scope`インターフェイスを実装したクラスを定義し,apply()にwhere を書く. overwriteすることになるため、selectは使用してはならない。それから、modelでboot()、その中でparent::boot();static::addGlobalScope(new YourNewScope);` を記述.
- Eloquentではイベントを発行できる。creating, updating, deleting等. これ利用してリアルタイムの投票結果システムなど構築できる.
- `cursor`メソッドにより、ひとつだけクエリを実行するカーソルを使用し、データベース全体を繰り返し処理できる。大量のデータを処理する場合、cursorメソッドを使用すると、大幅にメモリ使用量を減らすことができる。
```php
foreach (Flight::where('foo', 'bar')->cursor() as $flight) {
    //
}
```

```php
App\User::cursor()->filter(function ($user) {
    return $user->id > 500;
});
```
- Eager Loader を使わない場合`cursor()`を使ってもメモリ節約になる。
- The cursor method allows you to iterate through your database records using a cursor, `which will only execute a single query`.
- `Chunk` retrieves the records from the database, and `load it into memory` while setting a cursor on the last record retrieved so there is no clash. (`Chunk runs the query at every record size`)
- Laravel's select uses PHP's `fetchAll` whereas Laravel's cursor uses PHP's `fetch`. Both execute the same amount of SQL, but **the former** immediately builds `an array` with the whole data, whereas **the latter** fetches the data one row at a time, allowing to hold in memory **only this row**, not the previous nor the following ones. 

|              | Time(sec)  | Memory(MB) |
|:--------------|:------------:|:------------:|
| get()        |        0.8 |     132    |
| chunk(100)   |       19.9 |      10    |
| chunk(1000)  |        2.3 |      12    |
| chunk(10000) |        1.1 |      34    |
| cursor()     |        0.5 |      45    |
- cursor() is the fastest.
- `save`メソッドが呼ばれると新しいレコードがデータベースに挿入される。`save`が呼び出された時にcreated_atとupdated_atタイムスタンプは自動的に設定される。
- Eloquentの複数モデル更新を行う場合、更新モデルに対するsaving、saved、updating、updatedモデルイベントは発行されない。その理由は`複数モデル更新を行う時、実際にモデルが取得されるわけではないから`。
- モデル内部の状態が変化したかを判定し、ロード時のオリジナルな状態からどのように変化したかを調べるため、Eloquentは`isDirty`、`isClean`、`wasChanged`メソッド。
- `isDirty`メソッドはロードされたモデルから属性に変化があったかを判定します。特定の属性に変化があったかを調べるために、属性名を渡し指定できます。`isClean`メソッドは`isDirty`の反対の働き。
- `wasChanged`メソッドは現在のリクエストサイクル中、最後にモデルが保存されたときから属性に変化があったかを判定。
- Photoモデルのimageable(morph)関係は写真を所有しているモデルのタイプにより、`StaffもしくはOrderどちらかのインスタンス`をリターン。
```php
$posts = Post::has('comments')->get(); // 最低でも一つのコメントを持つ、全ブログポストを取得したい場合
$posts = Post::has('comments',has '>=', 3)->get(); // 演算子とレコード数も指定できる
$posts = Post::has('comments.votes')->get(); // ドット」記法
```
- Even more powerful way to use has. `orWhereHas` methods to put "where" conditions on your has queries:
```php
$posts = Post::whereHas('comments', function($q)
{
    $q->where('content', 'like', 'foo%');

})->get();
```
- `親のタイムスタンプの更新` : 子供のモデルが変更された場合、所属している(belongsTo)親のタイムスタンプも変更されると便利. `touches` を使う。（例えば、Commentモデルが更新されたら、Postが持っているupdated_atタイムスタンプも自動的に更新したい場合）
```php
class Comment extends Model {

    protected $touches = ['post']; // 更新したい親モデル

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

}
```
```php
$comment = Comment::find(1);

$comment->text = 'このコメントを変更！';

$comment->save(); // 関連づけてる親のupdate_at も更新される。
```
- pivot table を一通り触る https://www.yuulinux.tokyo/13566/
- 中間テーブルにもメソッドを持たせたい場合は `->using`.  `App\Models\Post::find(1)->tags->first()->pivot->hello();`こんな感じでpivot経由でアクセスできる。
- `->withTimestamps();` created_at とかupdate_atなどを適当にやってくれる。
- 中間テーブルに三つ目以降のテーブルもつけたい場合-> 中間テーブルにリレーションをつける。アクセスするときは、`pivot`経由で呼ぶ。 
- `App\Models\User::find(1)->groups->first()->pivot->role` 例えば、あるユーザが複数のグループに所属しているとき、それらのグループでそのユーザに割り振られているロールを取得したい場合。所属するそれぞれのグループ似て単一の役割が異なるときに使う。[参照](https://qiita.com/kkznch/items/72ff650737eff863e4d9)
- モデルメソッドもpivot経由しても使える。`App\Models\User::find(1)->groups->first()->pivot->role->upperName()`
- scope について. [参照](https://qiita.com/henriquebremenkanp/items/e21de43e4b9079265d7f)
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
- i vs 多数（Inverse）の場合　記事のブックマークやいいね！の場合は belong**s**To()
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
- all()で読み込んだ後に、load()を使う. 普通のEagerローディングはwith()
```pho
$books = Models\Book::all();
$books->load('author');
```
- 参照 https://readouble.com/laravel/5.5/ja/eloquent-relationship.html
```php
$books = Book::with('author', 'publisher')->get(); // 一度に複数の関係をEagerローディング
Book::with('author.contacts')->get(); // ネストした関連. author関係がEagerローディングされ、それからauthorのcontacts関係がEagerローディング
```
### 変数受け渡し方法
- https://qiita.com/ryo2132/items/63ced19601b3fa30e6de
### Eloquent コレクション
- ほとんどのEloquentコレクションは新しいEloquentコレクションのインスタンスを返す(`Illuminate\Database\Eloquent\Collection`)が、pluck、keys、zip、collapse、flatten、flipメソッドはベースのコレクションインスタンスを返す(`Illuminate\Support\Collection`)。Eloquentモデルをまったく含まないコレクションを返すmap操作のような場合、自動的にベースコレクションへキャストされる。
- `concat` ignores keys
- `filter` ignore any falsy values like `empty , 0, null, false, []`  
- the second value of filter is for key.
```php
filter(function($value, $key){`
    return $key > 2; 
});
```
- `mapWithKeys(function($items){ return [key=> value]})` is useful
- `isEmpty()` checks whether an array has an item or not, which means even falsy value in it, `isEmpty()` returns false always. only `[]` is true.  `isNotEmpty()` returns true. 
- `Collection::times()` allows you to granular control of `factory`.
```php
return Collection::times(3, function($value){
    return factory(User::class)->make([
        'name' => "{$value} cool name",    
    ]);
})->toArray();
- `toArray()` transforms from all dimensions of collection to array. however, `all()` does only the first dimension.
- `toJson()` returns Json. 
```
- collection メソッドを使うときは オリジナルコレクション を変更する（コレクション自身を更新）のか新しいコレクションを作るのかに注意する。
- `union`: 指定した配列をコレクションへ追加する。既にコレクションにあるキーが、オリジナル配列に含まれている場合は、オリジナルコレクションの値が優先される。
- `search` 値を探索して、key をリターン
- `split` と `chunk`はcollectionを分割するという点で似ているが、`chunk`は指定した数値で分割できない場合blows up. `split`は残りは残りだけでarrayを作る。
### Useful Eloquent Features
- `push()` : save a model and its corresponding relationships.
```php 
$user = User::first();
$user->name = "Peter";
$user->phone->number = '1234567890';
$user->push();
```
- `is()` model is the same or not.
```php
$user = App\User::find(1);
$sameUser = App\User::find(1); 
$user->is($sameUser);  // true 
```
- pass attributes to `find()`
```php
$user = App\User::find(1, ['name', 'age']);
```
- [Ref](https://medium.com/@JinoAntony/10-hidden-laravel-eloquent-features-you-may-not-know-efc8ccc58d9e)
### キャスト
- model の `$dates` プロパティにカラム名をセットしておけば、デフォルトで`Carbon`インスタンスにキャストされるため、どのそソッドでも使えるようになる。これはデータベースにはdatatimedで保存されているが、取り出し時に`Carbon`インスタンスにキャストされる。
- `$casts`にキャストしたいカラムを指定することもできる。同様にデータベースに保存してる内容を取り出した時にキャストする。`is_admin`が`0 or 1`で保存されていて取り出した時に`false or true`へキャストされる。
```php
protected $casts = [
        'is_admin' => 'boolean',
    ];
```
- オブジェクトのキャスト：これはモデルのインスタンスを取り出した時に整形し直す感じ。
- キャストする時にパラメータが必要な場合がある、例えば`Hash::class`の場合どのアルゴリズムを使うか指定が必要。この場合`：`を使用。複数のパラメータが必要なら、`,`で区切る。
```php
protected $casts = [
    'secret' => Hash::class.':sha256',
];
```
- モデルにカスタムキャストを指定する代わりに、`Illuminate\Contracts\Database\Eloquent\Castable`インターフェイスを実装するクラスを指定することも可能.
```php
namespace App;
use Illuminate\Contracts\Database\Eloquent\Castable;
use App\Casts\Address as AddressCast;
class Address implements Castable
{
    public static function castUsing()
    {
        return AddressCast::class; // Casts\ で別に定義
    }
}
- クエリ結果のキャストを`withCasts`でやる。
- というよりこの`select`の使い方をして、全クエリ結果を取ってきてimpodeみたいなキャストを追加すれば、キャスト結果でorderBy(last_posted_at)で一気にソートまでできる。
```php
$users = User::select([
    'users.*',
    'last_posted_at' => Post::selectRaw('MAX(created_at)')
            ->whereColumn('user_id', 'users.id')
])->withCasts([
    'last_posted_at' => 'datetime'
])->get();
```
### APIリソース
- リソースの本質はシンプル: **特定のモデルを配列に変換する**必要があるだけである。
- JSONへ変換する必要のある属性の配列を返す、`toArray`メソッドを定義
- **同期的な**API処理ならこれを使う。
- 条件付き属性: ユーザーが"administrator"の場合のみ、ある値を含めたいとき. `$this->when(...)` を使う。
- 条件付き属性のマージ: 
```php
'email' => $this->email,
        $this->mergeWhen(Auth::user()->isAdmin(), [
            'first-secret' => 'value',
            'second-secret' => 'value',
        ]),
 ...
```
- 条件付きリレーション: モデルインスタンスに他のモデル（リレーション）がロードされてる場合その他のモデルインスタンスを追加する。これはコントローラーでロードするか決めればあとは、リソースが適当に処理する。
```php
'posts' => PostResource::collection($this->whenLoaded('posts')), //リレーションがロードされていれば追加。
```
- トップレベルメタデータ の追加`with`
- hotexamples: https://hotexamples.com/examples/illuminate.database.query/Builder/macro/php-builder-macro-method-examples.html
### Eloquentシリアライズ
- EloquentモデルがJSONへ変換される場合、JSONオブジェクトへ属性として**自動的に**リレーションがロードされる。（ロードしたく無い場合は下記の`$hidden`を参照。）また、Eloquentのリレーションメソッドは「**キャメルケース**」で定義するが、リレーションのJSON属性は「**スネークケース**」になる。
- モデルから変換する配列やJSONに、パスワードのような属性を含めたくない場合がある。それにはモデルの`$hidden`プロパティに定義を追加する。
```php
namespace App;
use Illuminate\Database\Eloquent\Model;
class User extends Model
{
    /**
     * 配列に含めない属性
     *
     * @var array
     */
    protected $hidden = ['password'];
    
    // または含める物だけを$visibleに指定する
    /**
     * 配列中に含める属性
     *
     * @var array
     */
    protected $visible = ['first_name', 'last_name'];

}
```
- リレーションを含めない場合は、メソッド名を`$hidden`に指定。
- **プロパティ配列出力管理の一時的変更**： 特定のモデルインスタンスにおいて、通常は配列に含めない属性を含めたい場合は、`makeVisible`メソッドを使う。このメソッドは、メソッドチェーンしやすいようにモデルインスタンスを返す。
```php
   return $user->makeVisible('attribute')->toArray();
   return $user->makeHidden('attribute')->toArray();
```
- 
- データベースに無いカラムを追加したい場合、キャメルケースでアクセサを作って、モデルの$appends プロペティにスネークケースで追加する。
```php
public function getIsAdminAttribute()
{
    return $this->attributes['admin'] === 'yes';
}
/**
 * モデルの配列形態に追加するアクセサ
 *
 * @var array
 */
protected $appends = ['is_admin'];
```
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
-  `app\Providers\RouteServiceProvider`により、`routes/web.php`ファイルでは、`webミドルウェアグループ`が自動的に適用されている。
- **`handle`と`terminate`メソッドの呼び出しで同一のミドルウェアインスタンスを使用したい場合**は、コンテナのsingletonメソッドを使用し、ミドルウェアを登録する。通常、`AppServiceProvider.php`のregisterメソッドの中で登録。
- 現状だと**Middlewareの中でsessionを使ってkey valueを保存するとき**は、`Session:save()`も必要。Redisを使うときは必要なし。
### Two ways to test out methods
1. make commands by hitting something like `php artisan make:command CollectionComamnd` and add this class to `Console\Kernel.php`. After that, edit `CollectionCommand@handle` to specify what actions you want trigger when hitting the command. it's always good idea to use with `clear` command like `clear && php artisan collection:example`.
2. use shell script something like below and run it. when you want to reload scripts hit `control-D` and if you want to quit, hit `control-C`.
```shell script
#!/bin/sh
while true; do php artisan tinker; done
```
### phpbrew: php version control.
- _installating phpbrew_ https://github.com/phpbrew/phpbrew/wiki/Quick-Start
```shell script
curl -L -O https://github.com/phpbrew/phpbrew/raw/master/phpbrew
chmod +x phpbrew

# Move phpbrew to somewhere can be found by your $PATH
sudo mv phpbrew /usr/local/bin/phpbrew
phpbrew init
```
- update package. `phpbrew update`
- install specific version. `phpbrew --debug install --stdout 7.0 as 7.0-dev +default +intl`
- list of version. `phpbrew list`
- use temporarily `phpbrew use [version`
- use a default `phpbrew switch [version`
- and let use php 7.4
### The diffs bt with() and load()
- https://stackoverflow.com/questions/26005994/laravel-with-method-versus-load-method
### Event
- オブザーバーパターン: 監視する側(リスナー)と監視される側(イベント)に分けて、イベントの変化をリスナーが受け取って処理をする。
- 一つのイベントは、互いに依存していない**複数**のリスナに紐付けられますので、**アプリケーションのさまざまな要素を独立させるための良い手段**として活用できます。
- 注文を配送するごとにSlack通知をユーザーへ届けたいとします。注文の処理コードとSlackの通知コードを**結合する代わりに**、OrderShipped**イベントを発行**し、**リスナがそれを受け取り、Slack通知へ変換するように実装**できます。
- 初めに `EventServiceProvider.php` にイベントとリスナを登録する。
- それから `php artisan event:generate` で自動でイベント、リスナを生成する。
```php
'App\Events\OrderShipped' => [
          'App\Listeners\SendShipmentNotification',
        ],
```
- イベント・リスナを個々に作成する方法。First create event by running `php artisan make:event AuctionUserWasOutbidded` You then need a listener to handle this event. Generate one with: `php artisan make:listener EmailOutbiddedUser --event=AuctionUserWasOutbidded` Use event option to bind them. Lastly, bind them in `protected $listen` in `EventServiceProvider` like `'SLOCO\Events\AuctionUserWasOutbidded' => ['SLOCO\Listeners\EmailOutbiddedUser',],`
- `EventServiceProvider`の`boot`にロージャベースリスナを登録できる。
- `Event Discovery` 自分でイベントとリスナを登録しなくても、laravelが（リフレクションを使い）`Listeners` ディレクトリを探索（スキャン）して解決してくれる。そして見つけ出したら、`EventServiceProvider`に自ら登録する。
- イベントのhandleメソッドにDIしたタイプヒントを元に`Listeners`を探索。
- イベントディスカバリはデフォルトで無効。アプリケーションの`EventServiceProvider`にある`shouldDiscoverEvents`をオーバーライドすることで、有効にする。
- アプリケーションの`Listeners`ディレクトリ中の全リスナが、デフォルトでスキャンされる。 スキャンする追加のディレクトリを定義したい場合は、EventServiceProviderの`discoverEventsWithin`をオーバーライドする。
```php
protected function discoverEventsWithin()
{
    return [
        $this->app->path('Listeners'),
    ];
}
```
- 実働時はリクエストのたびに、すべてのリスナをフレームワークにスキャンさせるのは好ましくない。アプリケーションのイベントとリスナの全目録をキャッシュする、`event:cache` Artisanコマンドを実行すべき。この目録はフレームワークによるイベント登録処理をスピードアップするために使用される。`event:clear`コマンドにより、このキャッシュは破棄される。
- `event:list`コマンドで、アプリケーションに登録されたすべてのイベントとリスナを一覧表示。
- イベントリスナはイベントインスタンスをhandleメソッドで受け取る。
- イベントの伝播の停止: 場合によりイベントが他のリスナへ伝播されるのを止めたいこともあります。その場合はhandleメソッドからfalseを返してください。
- ShouldQueueトレイトを使うだけで、リスナがイベントのために呼び出されると、Laravelのキューシステムを使い、イベントデスパッチャーにより自動的にキューへ投入される。キューにより実行されるリスナから例外が投げられなければ、そのキュージョブは処理が済み次第、自動的に削除される。
- `Dispatchable`：イベントを発火させる(ディスパッチ)ときに利用
- `InteractsWithSockets`：socket.ioを使用したイベント通知時利用
- `SerializesModels`：キューと組み合わせて非同期イベントを発火させるためのもの
- ログイン、ログアウトなどの同じ分類の処理をリスナーにやらせたい時には、`Subscriber` を使う。
### キュー
- キューワーカは長時間起動するプロセスで、メモリ上にアプリケーション**起動時の状態を保存している**ことを記憶にとどめてください。そのため、**開発段階ではキューワーカの再起動を確実に実行してください**。付け加えて、アプリケーションにより生成、もしくは変更された**静的な状態**は、ジ`ョブ間で自動的にリセットされない`ことも覚えておきましょう。コードを修正したら `php artisan queue:listen` は更新したコードをリロード、もしくはプリケーションの状態をリセットしたい場合に、手動でワーカをリスタートする必要がなくなる。
- `nohup php artisan queue:work --daemon &` バックグラウンドでワーカーを起動。`nohup.out` をカレントディレクトリに作成してログをする。
- email キューのみ処理を行いたいときは、`php artisan queue:work redis --queue=emails`のように指定する。
- `php artisan queue:work --queue=high,low`とすればhighキューが先に処理されるようになるため、優先度がと高い処理をこのキューを使うようにディスパッチする。`dispatch((new Job)->onQueue('high'));`php artisan queue:retry 5
- ジョブの有効期限: 処理中のジョブを再試行するまで何秒待つか。もし有効期限が90秒でジョブが90秒たっても完了しないときは、キューに再投入される。この有効期限を`config/queue.php` の`retry_after`で設定する。Amazon SQSはAWSコンソールで管理。
- 子のキューワーカのタイムアウトは`--timeout=60`のように設定。
- ジョブ失敗イベント: `Queue::failing` を`AppServiceProvider`のbootに追加する。
- ジョブ失敗イベントの確認: `php artisan queue:failed`
- 実行 `php artisan queue:retry 5` 
#### Supervisor
- 一番時間がかかるジョブが消費する秒数より大きな値を`stopwaitsecs`へ必ず指定
-  `service supervisor start` で走らせる。
### ブロードキャスト
- Laravelでイベントをブロードキャストすることにより、サーバサイドのコードとクライアントサイドのJavaScriptで、同じ名前のイベントを共有することができる
- イベントのブロードキャストは、すべてキュージョブとして行われるため、アプリケーションのレスポンスタイムにはシリアスな影響はでない
- パブリック、もしくはプライベートに指定された「チャンネル」上で、イベントはブロードキャストされます。**アプリケーションの全訪問者**は、認証も認可も必要ない**パブリックチャンネル**を購入できます。しかし、**プライベートチャンネル**を購入するためには、認証され、そのチャンネルをリッスンできる**認可**が必要です。
- 使用例：ユーザーに注文の発送状態を確認してもらうビューページがあるとしましょう。さらに、アプリケーションが発送状態を変更すると、`ShippingStatusUpdated`イベントが発行されるとしましょう。ユーザーがある注文を閲覧している時に、ビューの状態を変更するために、ユーザーがページを再読込しなくてはならないなんてしたくありません。代わりにアップデートがあることをアプリケーションへブロードキャストしたいわけです。
- First of all, hit `php artisan make:event ShippingStatusUpdated`
- `ShouldBroadcast`インターフェイスはイベントで、`broadcastOn`メソッドを定義することを求めています。
- `PrivateChannel` には特定のユーザーのみが購読できるようにroutes/channels.php にルールを設定する。
- **チャンネルの名前**と、ユーザーにそのチャネルをリッスンする認可があるかどうかを**trueかfalseで返すコールバック**です。
```phpv
Broadcast::channel('order.{orderId}', function ($user, $orderId) {
    return $user->id === Order::findOrNew($orderId)->user_id;
});
```
### キャッシュ
- `Illuminate\Contracts\Cache\Factory`と`Illuminate\Contracts\Cache\Repository`契約は、Laravelのキャッシュサービスへのアクセスを提供
- Factory契約は、アプリケーションで定義している**全キャッシュドライバ**へのアクセスを提供。Repository契約は通常、cache設定ファイルで指定している、アプリケーションの**デフォルトキャッシュドライバ**の実装
- `redis-cli monitor` monitor any transaction.
- `keys *` shows all keys.
- `Cache::has('key')` keyの存在確認
- **取得不可時更新**: 全ユーザーをキャッシュから取得しようとし、存在していない場合はデータベースから取得しキャッシュへ追加したい場合. キャッシュに存在しない場合、rememberメソッドに渡された「クロージャ」が実行され、結果がキャッシュに保存される。

```php
$value = Cache::remember('users', $seconds, function () {
    return DB::table('users')->get();
});
```
- **非存在時保存**: `add`メソッドはキャッシュに保存されていない場合のみ、そのアイテムを保存。キャッシュへ実際にアイテムが**追加された場合**は`true`が返ってきます。そうでなければfalseが返されます。
- キャッシュ全体をクリアしたい場合は`flush`メソッド
- `アトミックロック`: memcachedかdynamodb、redisドライバを使用する必要がある。さらに、すべてのサーバが**同じ中央キャッシュサーバに接続する**必要がある。
    - アトミックロックにより`競合状態を心配することなく、分散型のロック操作を実現できる`
    - Laravel Forgeでは、`一度に１つのリモートタスクを１つのサーバで実行するため`に、アトミックロックを使用
    - ロックを生成し、管理するには`Cache::lock`メソッドを使用
    - getメソッドは、クロージャも引数に取り, `クロージャ実行後Laravel は自動的にロックを解除`する
    - リクエスト時に`ロックが獲得できないとき`に、`指定秒数待機するようにLaravelに指示できる`。指定制限時間内にロックが獲得できなかった場合は、`Illuminate\Contracts\Cache\LockTimeoutException`が投げられる。`$lock->block(5);`
    - リクエスト時に`ロックが獲得できないとき`に、`指定秒数待機するようにLaravelに指示できる`。指定制限時間内にロックが獲得できなかった場合は、`Illuminate\Contracts\Cache\LockTimeoutException`が投げられる。`$lock->block(5);`でロックを獲得するように待機。
    - 別々のプロセス間でロック管理を共通で行いたいとき: ロックを限定する「所有者トークン」を渡す。`$lock->owner()`, then `Cache::restoreLock('SomeKey', $this->owner)->release();`

```php
$lock = Cache::lock('foo', 10);
if ($lock->get()) {
    // １０秒間ロックを獲得する

    $lock->release();
}
``` 

```php
Cache::lock('foo')->get(function () {
    // 無期限のロックを獲得し、自動的に開放する
});
```

```php
$lock = Cache::lock('foo', 10);

try {
    $lock->block(5);

    // 最大５秒待機し、ロックを獲得
} catch (LockTimeoutException $e) {
    // ロックを獲得できなかった
} finally {
    optional($lock)->release();
}

Cache::lock('foo', 10)->block(5, function () {
    // 最大５秒待機し、ロックを獲得
});
```

- `tag` で追加することで複数の関連するキーをまとめて扱うことができる。`Cache::tags(['people'])->flush();`　`people`にタグ付けされたキーは全て消去される。
- イベント：キャッシュの操作に対してイベントを実行する場合は通常、イベントリスナは`EventServiceProvider`の中へ設置する。

### File Storage
- `publicディスク`は一般公開へのアクセスを許すファイル
- デフォルトのpublicディスクは、`localドライバ`を使用しており、`storage/app/public`下に存在しているファイル
- Webからのアクセスを許すには、`public/storage`から`storage/app/public`へ`シンボリックリンク`を張る必要がある `php artisan storage:link` ファイルを保存し、シンボリックリンクを貼ったら、assetヘルパを使いファイルへURLを生成できる。 `echo asset('storage/file.txt');`
- ローカルディスク: デフォルトでは`storage/appディレクトリ` `Storage::disk('local')->put('file.txt', 'Contents');` は`storage/app/file.txt`として保存
- s3 を使う：　https://qiita.com/tiwu_official/items/ecb115a92ebfebf6a92f
- `Storage::disk('s3')->exists('filename.txt');` 指定したディスクにファイルが存在しているかを判断
- `return Storage::download('file.jpg');` ダウンロード
- store メソッドを使えばデフォルトのフォルダにシンプルにアップロードできる。以下の例では、ファイル名ではなく、ディレクトリ名を指定している点に注目。デフォルトでstoreメソッドは、一意のIDをファイル名として生成する。ファイルの拡張子は、MIMEタイプの検査により決まる。
```php
public function update(Request $request)
    {
        $path = $request->file('avatar')->store('avatars');

        return $path;
    }
```
- 視認性：
```php
$visibility = Storage::getVisibility('file.jpg');

Storage::setVisibility('file.jpg', 'public');
```
## Helpers
- `rescue`関数は指定されたクロージャを実行し、実行時に発生する例外をキャッチします。キャッチされた例外は、すべて例外ハンドラのreportメソッドに送られます。しかし、リクエストは引き続き処理されます。
```php
return rescue(function () {
    return $this->method();
});
```
- `throw_if`関数は、指定した論理式がtrueと評価された場合に、指定した例外を投げます。
```php
throw_if(! Auth::user()->isAdmin(), AuthorizationException::class);

throw_if(
    ! Auth::user()->isAdmin(),
    AuthorizationException::class,
    'You are not allowed to access this page'
);
```
- `validator`関数は、指定した引数で新しいバリデータインスタンスを生成します。利便のため、Validatorファサードを代わりに使うこともできます。
```php
$validator = validator($data, $rules, $messages);
```
### 設定
- テスト環境での設定 .env ファイル　`.env.testing` とするとPHPUnitテスト実行時（`./vendor/bin/phpunit`）やArtisanコマンドへ`--env=testing`オプションを指定した場合に、`.env`ファイルをオーバーライドする。
- **空白を含む値**を環境変数に定義する場合は、**ダブル引用符**で囲う。
```
APP_NAME="My Application"
```
- 現在のアプリケーション環境の情報取得
```php
$environment = App::environment();
```
```php
if (App::environment('local')) {
    // 環境はlocal
}

if (App::environment(['local', 'staging'])) {
    // 環境はlocalかstaging
}
```
- メンテナンスモードにする。
```shell script
php artisan down --message="Upgrading Database" --retry=60
```
- メンテナンスモードから抜けるには、`up`コマンド。
```shell script
php artisan up
```
- コマンドのallowオプションを使用し、メンテナンスモードであっても、アプリケーションへアクセスを許すIPアドレスやネットワークを指定できる。
```shell script
php artisan down --allow=127.0.0.1 --allow=192.168.0.0/16
```
- 環境毎に`.env`を変える
   - APP_ENVの値によって、`.env`ファイルを切替
```apacheconfig
# .htaccess
SetEnvIf Host "production.co.jp" APP_ENV=prod # .env.prod
SetEnvIf Host "staging.co.jp" APP_ENV=stg     # .env.stg
SetEnvIf Host "development.co.jp" APP_ENV=dev # .env.dev
```
   - またはlaravel の `loadEnvironmentFrom`メソッドを使う
```php
$app = new Illuminate\Foundation\Application(
    realpath(__DIR__.'/../')
);
switch ($_SERVER['SERVER_NAME'] ?? 'localhost') {
    case 'development.co.jp':
        $app->loadEnvironmentFrom('.env.dev');
        break;
    case 'staging.co.jp':
        $app->loadEnvironmentFrom('.env.stg');
        break;
    case 'production.co.jp':
        $app->loadEnvironmentFrom('.env.prod');
        break;
}
```
- [参照](https://qiita.com/takaday/items/b992c7d8cd69343b6626)
### Use bootstrap on laravel
- install bootstrap `php artisan ui bootstrap` then `npm install && npm run dev`

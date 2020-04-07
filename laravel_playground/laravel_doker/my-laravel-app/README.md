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

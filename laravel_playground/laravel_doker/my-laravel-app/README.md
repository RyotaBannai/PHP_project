### chachファサードとredis ファサード

- **Cacheファサード**:キャッシュを扱う際にどの方式（ファイルでもDBでもNoSQLでも）を採用しても共通して使えるメソッド。
- 一方、RedisファサードはRedis操作のためのクラスであり、Redisコマンドの全てをコールする事ができる。

### DI: Dependency Injection: 依存性の注入 = 依存している部分を、外から注入すること.
- Laravelでは、DI コンテナな（サービスコンテナ）を中心としてフレームワークが作られている.
- DI の方法は以下の3つ：
    1. メソッド・インジェクション
    2. セッタ・インジェクション
    3. コンストラクタ・インジェクション
- 1. **メソッドの引数に依存対象のクラスを渡すこと**：
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
- 2. DI用のセッタを用意し依存対象のクラスを渡すこと：
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
- 3. コンストラクタに依存対ソフおnクラスを渡すこと：
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

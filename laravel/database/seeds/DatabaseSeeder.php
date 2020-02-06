<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(BooksTableSeeder::class); //作成したシードを実行するために, この一文も必要. 
        /*
            php artisan db:seed　を実行.
            php artisan db:seed --class=BooksTableSeeder で個別のseedを実行.
            php artisan migrate:refresh --seed データベースを初期化し, seedを投入.
        */
    }
}

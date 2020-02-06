<?php

use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    //作り立てのDBにシード投入.
    public function run()
    {
        DB::insert('INSERT INTO books (isbn, title, price, publisher, published) VALUES("987-6543-210", "Visual C 2019超入門", 2000, "日経BP", "2019-08-22")');
    }
}

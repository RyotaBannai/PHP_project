<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name'=> Str::random(10),
            'email'=> Str::random(10).'@gmail.com',
            'email_verified_at'=> new DateTime(),
            // 'email'=> str_random(10), '@gmail.com', str_random is depricated
            'password'=> bcrypt('secret'),
            'remember_token'=> '',
            'created_at'=> new DateTime(),
            'updated_at'=> new DateTime(),
        ]);
    }
}

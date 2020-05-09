<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Image;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $userDB = DB::table('users');
        $postDB = DB::table('posts');
        $imageDB = DB::table('images');
        $userDB->truncate(); // or use model like this: User::truncate();
        // $userDB->delete(); // doesn't reset auto increment counter.. so use truncate.
        $postDB->truncate();
        $imageDB->truncate();

        // $users = factory(User::class, 10)->create();
        $users = factory(User::class, 10)
            ->create()
            ->map(function($user){ // each だと戻らないため
                return $user->posts()->saveMany(factory(Post::class, 2)->create([
                    'user_id' => $user->id, // overwrite default setting
               ]));
            })->flatten(); // 1ユーザーに対し複数のpostインタンスを生成してるためcollectionになるため

        $users = $users->each(function($post){
        // $post->images()->save(factory(Image::class)->make([
        $post->images()->saveMany(factory(Image::class, Arr::random([0, 1, 2, 3]))->make([
            'target_id' => $post->id,
            'target_type' => 'App\Models\Post',
            ]));
        });
    }
}
        // use factory instead of seed file.
//        $faker = Faker\Factory::create();
//        for($i=0, $end=10; $i < $end; ++$i) {
//            $userDB->insert([
//                'name' => $faker->userName
//            ]);
//        }

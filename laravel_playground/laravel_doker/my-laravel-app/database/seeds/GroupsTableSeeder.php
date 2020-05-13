<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Group;

class GroupsTableSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        $groupDB = DB::table('groups');
        $groupDB->truncate();
        $groups = [
            'Developer', 'Admin', 'User', 'Poweruser'
        ];
        foreach ($groups as $group)
            Group::create([
                'name' => $group,
                'created_at' => $faker->dateTime,
                'updated_at' => $faker->dateTime
            ]);
    }
}

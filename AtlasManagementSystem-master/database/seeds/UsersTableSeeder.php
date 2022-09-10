<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
   DB::table('users')->insert([
            'over_name' => '鈴木',
            'under_name' => '寿治',
            'over_name_kana' => 'スズキ',
            'under_name_kana' => 'トシハル',
            'mail_address' => 'TT@jp',
            'password' => bcrypt('123456'),
            'sex'=> '1',
            'birth_day'=> '1995/03/02',
            'role'=> '1',
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "Avinash Rijal";
        $user->username = "user";
        $user->gender = "male";
        $user->email = "avlasgamer2427@gmail.com";
        $user->password = crypt("user","");
        $user->save();
    }
}

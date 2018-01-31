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
        $user->name = "Zaffron Velemo";
        $user->username = "user";
        $user->email = "avlasgamer2427@gmail.com";
        $user->password = crypt("secret","");
        $user->save();
    }
}

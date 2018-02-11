<?php

use Illuminate\Database\Seeder;



use App\Admin;

class AdminUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $user = new Admin();
	    $user->name = "Zaffron Admino";
	    $user->username = "root";
        $user->gender = "male";
        $user->email = "avlasgamer2427@gmail.com";
        $user->password = crypt("root","");
	    $user->save();
    }
}

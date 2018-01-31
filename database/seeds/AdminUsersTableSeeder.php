<?php

use Illuminate\Database\Seeder;

use App\AdminUser;

class AdminUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $user = new AdminUser();
	    $user->name = "Zaffron Admino";
	    $user->username = "zaffron";
	    $user->email = "avlasgamer2427@gmail.com";
	    $user->password = crypt("secret","");
	    $user->save();
    }
}

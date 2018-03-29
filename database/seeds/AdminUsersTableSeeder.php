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
	    $admin = new Admin();
	    $admin->name = "Zaffron Admino";
	    $admin->username = "root";
        $admin->gender = "male";
        $admin->email = "avlasgamer2427@gmail.com";
        $admin->password = crypt("root","");
	    $admin->save();
    }
}

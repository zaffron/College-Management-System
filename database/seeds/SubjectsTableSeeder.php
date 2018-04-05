<?php

use Illuminate\Database\Seeder;
use App\Subject;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subject = new Subject();
	    $subject->name = "CNS";
	    $subject->description = "Cryptography and network security";
	    $subject->save();

	    $subject = new Subject();
	    $subject->name = "WP";
	    $subject->description = "Web Programming";
	    $subject->save();
	    
	    $subject = new Subject();
	    $subject->name = "SP";
	    $subject->description = "System Programming";
	    $subject->save();
	    
    }
}

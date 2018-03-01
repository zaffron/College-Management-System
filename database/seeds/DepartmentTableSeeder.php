<?php

use App\Department;
use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $department = new Department();
        $department->name = "BCA";
        $department->description = "Bachelor of computer application";
        $department->teachers_count = 0;
        $department->course = 1;
        $department->save();

        $department1 = new Department();
        $department1->name = "MCA";
        $department1->course = 2;
        $department1->description = "Masters of computer application";
        $department1->teachers_count = 0;
        $department1->save();
    }
}

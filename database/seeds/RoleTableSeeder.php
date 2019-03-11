<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $owner = new Role();
        $owner->label = 'employee';
        $owner->save();

        $admin = new Role();
        $admin->label = 'admin';
        $admin->save();
    }
}

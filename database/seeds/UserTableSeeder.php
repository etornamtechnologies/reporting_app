<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name'=> 'etornam anyidoho',
            'username'=> 'etoretornam',
            'email'=> 'etornamanyidoho@outlook.com',
            'password'=> bcrypt('143541etor')
        ]);
        $admin->roles()->attach(Role::where('label', 'admin')->first());
    }
}

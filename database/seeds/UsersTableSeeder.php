<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $doctor = User::create([
        	'username' => 'doctor',
        	'password' => bcrypt(123456),
        	'name' => 'پزشک',
        	'mobile' => '09123456789',
        	'email' => 'a@b.com'
        ]);

        $nurse = User::create([
        	'username' => 'nurse',
        	'password' => bcrypt(123456),
        	'name' => 'منشی',
        	'mobile' => '09123456789',
        	'email' => 'a@b.com'
        ]);

        Role::create([
        	'name' => 'clerk'
        ]);

        Role::create([
        	'name' => 'doctor'
        ]);

        DB::table('role_users')->insert([
        	'role_id' => 2,
        	'user_id' => $doctor->id
        ]);

        DB::table('role_users')->insert([
        	'role_id' => 1,
        	'user_id' => $nurse->id
        ]);
    }
}

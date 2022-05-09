<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <20; $i++){
            \Illuminate\Support\Facades\DB::table('users')->insert([
                'name'=>"John Doe$i",
                'email'=>"JohnDoe$i@mail.op",
                'password' =>   bcrypt('0000')
            ]);
        }
    }
}

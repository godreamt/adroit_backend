<?php

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
        User::reguard();        
        User::insert($this->seed_data());   
    }

    

    private function seed_data()
    {
        $seed = array(
            array(
                'firstName' => 'Kiran',
                'lastName' => 'Suratkal',
                'mobileNumber' => '7899866288',
                'email' => 'test@me.com',
                'roles' => 'admin',
                'isActive' => '1',                
                'password' => bcrypt('1234567'),  
                'email_verified_at'=> date('Y-m-d H:i:s'),               
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ) 
        );
        return $seed;
    }
}

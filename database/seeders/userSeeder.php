<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'name'=>'shubham',
                'email'=>'shubham@gmail.com',
                'password'=>'12345678',
            ],
            [
                'name'=>'shubham chauhan',
                'email'=>'shubhamchauhan@gmail.com',
                'password'=>'87654321',
            ]
        ];
        foreach($datas as $data){
            User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password']),
        ]);
        }
        // User::create([
        //     'name'=>'Shubham Singh Chauhan',
        //     'email'=>'shubham@gmail.com',
        //     'password'=>Hash::make('12345678'),
        // ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class User_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employee')->insert([
                'userName' => 'Shima',
                'userAddress' => '616, Jalan Melati, Selangor',
                'userPhoneNum' => '01110890034',
                'userPosition' => 'HQ',
                'email' => 'shima@gmail.com',
                'password' => 'shima123'
        ]);

        DB::table('employee')->insert([
            'userName' => 'Kesh',
            'userAddress' => '1, Jalan Hati, Negeri Sembilan',
            'userPhoneNum' => '01310890033',
            'userPosition' => 'Master Agent',
            'email' => 'kesh@gmail.com',
            'password' => 'kesh123'
        ]);

        DB::table('product_quantity')->insert([
            'employeeId' => 1
        ]);

        DB::table('product_quantity')->insert([
            'employeeId' => 2
        ]);

    }
}

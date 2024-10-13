<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $malaysianStates = [
            ['code' => 'MY-01', 'name' => 'Johor'],
            ['code' => 'MY-02', 'name' => 'Kedah'],
            ['code' => 'MY-03', 'name' => 'Kelantan'],
            ['code' => 'MY-04', 'name' => 'Melaka'],
            ['code' => 'MY-05', 'name' => 'Negeri Sembilan'],
            ['code' => 'MY-06', 'name' => 'Pahang'],
            ['code' => 'MY-07', 'name' => 'Perak'],
            ['code' => 'MY-08', 'name' => 'Perlis'],
            ['code' => 'MY-09', 'name' => 'Pulau Pinang'],
            ['code' => 'MY-10', 'name' => 'Sabah'],
            ['code' => 'MY-11', 'name' => 'Sarawak'],
            ['code' => 'MY-12', 'name' => 'Selangor'],
            ['code' => 'MY-13', 'name' => 'Terengganu'],
            ['code' => 'MY-14', 'name' => 'Wilayah Persekutuan Kuala Lumpur'],
            ['code' => 'MY-15', 'name' => 'Wilayah Persekutuan Labuan'],
            ['code' => 'MY-16', 'name' => 'Wilayah Persekutuan Putrajaya'],
        ];

        foreach ($malaysianStates as $state) {
            State::updateOrCreate(
                ['code' => $state['code']], // Search condition
                ['name' => $state['name']]  // Values to insert
            );
        }
    }
}

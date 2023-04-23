<?php

namespace Database\Seeders;

use App\Models\CarAgencies;
use Illuminate\Database\Seeder;

class CarAgenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i<1000; $i++)
        {
            $car_agencies  = new CarAgencies();
            $car_agencies->name_ar = $i.'الوكاله ';
            $car_agencies->name_en = 'Agencies '.$i;
            $car_agencies->status = 'active';
            $car_agencies->created_at = now();
            $car_agencies->save();
        }
    }
}

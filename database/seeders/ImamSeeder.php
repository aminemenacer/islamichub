<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Imam;


class ImamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Imam::truncate();

        $csvFile = fopen(base_path("database/data/ahadith/hadith_imam.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Imam::create([
                    "imam_name" => $data['0'],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}

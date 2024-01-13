<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ahadith;

class AhadithSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ahadith::truncate();

        $csvFile = fopen(base_path("database/data/ahadith/hadith_ahadith.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Ahadith::create([
                    // "id" => $data['0'],
                    "imam_id" => $data['0'],
                    "chapter_id" => $data['1'],
                    "hadith_ar" => $data['2'],
                    "hadith_en" => $data['3'],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}

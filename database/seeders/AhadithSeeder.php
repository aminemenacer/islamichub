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
                // Check if the necessary keys exist in the array
                if (isset($data['0']) && isset($data['1']) && isset($data['2']) && isset($data['3'])) {
                    Ahadith::create([
                        "imam_id" => $data['0'],
                        "chapter_id" => $data['1'],
                        "hadith_ar" => $data['2'],
                        "hadith_en" => $data['3'],
                    ]);
                } else {
                    // Handle the case where keys are missing (e.g., log an error, skip the row, etc.)
                    // For example, you might log an error message:
                    error_log("Missing key in CSV row: " . json_encode($data));
                }
            }
            $firstline = false;
        }
        

        fclose($csvFile);
    }
}

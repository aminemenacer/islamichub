<?php

namespace Database\Seeders;

use App\Models\Ayah;
use Illuminate\Database\Seeder;

class AyahSeeder extends Seeder
{
    public function run()
    {
        Ayah::truncate();
  
        $csvFile = fopen(base_path("database/data/csv/ayat.csv"), "r");
  
        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, "|")) !== FALSE) {
            if (!$firstline) {
                // Check if the $data array has the expected number of elements
                if (count($data) === 4) {
                    // Convert ayah_text to UTF-8 encoding if needed
                    $ayahText = isset($data[3]) ? mb_convert_encoding($data[3], 'UTF-8', 'auto') : ''; // Convert to UTF-8
                    Ayah::create([
                        "surah_id" => $data[0],
                        "ayah_id" => $data[1],
                        "audio_links" => $data[2],
                        "ayah_text" => $ayahText,
                    ]);
                } else {
                    // Log or handle the missing entry
                    echo "Missing value in CSV row: " . implode(",", $data) . PHP_EOL;
                    // Add more debugging info if needed
                    var_dump($data);
                }
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}

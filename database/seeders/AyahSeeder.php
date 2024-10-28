<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ayah;

class AyahSeeder extends Seeder
{
    public function run()
    {
        Ayah::truncate();

        $csvFile = fopen(base_path("database/data/csv/ayat.csv"), "r");
  
        $firstline = true;
        $audioCounter = 1; // Start the audio counter from 1 or any desired start point

        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                if (count($data) === 4) {
                    // Ensure ayah text is UTF-8 encoded
                    $ayahText = isset($data[3]) ? mb_convert_encoding($data[3], 'UTF-8', 'auto') : ''; 

                    // Update audio link with incremented counter
                    $audioLink = preg_replace(
                        '/\/ar\.alafasy\/\d+\.mp3$/', 
                        "/ar.alafasy/$audioCounter.mp3", 
                        $data[2]
                    );

                    Ayah::create([
                        "surah_id" => $data[0],
                        "ayah_id" => $data[1],
                        "audio_links" => $audioLink,
                        "ayah_text" => $ayahText,
                    ]);

                    $audioCounter++; // Increment the counter for the next audio link
                } else {
                    echo "Missing value in CSV row: " . implode(",", $data) . PHP_EOL;
                    var_dump($data);
                }
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}

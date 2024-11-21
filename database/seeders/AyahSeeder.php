<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ayah;

class AyahSeeder extends Seeder
{
    public function run()
    {
        Ayah::truncate();

        $csvFilePath = base_path("database/data/csv/ayat.csv");
        if (!file_exists($csvFilePath)) {
            echo "CSV file not found at path: $csvFilePath";
            return;
        }

        $csvFile = fopen($csvFilePath, "r");
        $isHeader = true;

        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            // Skip the header line
            if ($isHeader) {
                $isHeader = false;
                continue;
            }

            if (count($data) === 4) {
                // Ensure ayah text is UTF-8 encoded
                $ayahText = isset($data[3]) ? mb_convert_encoding($data[3], 'UTF-8', 'auto') : '';

                // Directly use the audio link from the CSV file
                $audioLink = $data[2];

                // Check if the audio link is not empty and valid
                if (!empty($audioLink)) {
                    Ayah::create([
                        "surah_id" => $data[0],
                        "ayah_id" => $data[1],
                        "audio_links" => $audioLink,
                        "ayah_text" => $ayahText,
                    ]);
                } else {
                    echo "Missing audio link for Ayah: " . $data[1] . PHP_EOL;
                }
            } else {
                echo "Invalid row format: " . implode(",", $data) . PHP_EOL;
            }
        }

        fclose($csvFile);
    }
}


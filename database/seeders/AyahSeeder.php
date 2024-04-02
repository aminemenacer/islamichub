<?php

namespace Database\Seeders;

use App\Models\Ayah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AyahSeeder extends Seeder
{
    public function run()
    {
        Ayah::truncate();
  
        $csvFile = fopen(base_path("database/data/csv/ayat.csv"), "r");
  
        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Ayah::create([
                    "surah_id" => $data['0'],
                    "ayah_id" => $data['1'],
                    "audio_links" => $data['2'],
                    "ayah_text" => $data['3'],
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}
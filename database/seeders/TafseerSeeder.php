<?php

namespace Database\Seeders;

use App\Models\Tafseer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TafseerSeeder extends Seeder
{
    
    public function run()
    {
       
        Tafseer::truncate();
  
        $csvFile = fopen(base_path("database/data/csv/tafseer.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Tafseer::create([
                    "tafseer" => $data['0'],
                    "ayah_id" => $data['1']
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
    
}

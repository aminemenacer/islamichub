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
        // Replace this path with the path to your SQL file
        // $sqlFile = base_path('database/data/ayah.sql');


        // // Read the SQL file content
        // $sql = file_get_contents($sqlFile);



        // try {
        //     if ($sql !== false) {
        //         DB::unprepared($sql);
        //     } else {
        //         $this->command->info('SQL file not found.');
        //     }
        // } catch (\Exception $e) {
        //     $this->command->info('Error occurred: ' . $e->getMessage());
        // }

        Ayah::truncate();
  
        $csvFile = fopen(base_path("database/data/csv/ayat.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Ayah::create([
                    "id" => $data['0'],
                    "surah_id" => $data['1'],
                    "ayah_id" => $data['2'],
                    "ayah_text" => $data['3']
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}

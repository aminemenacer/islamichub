<?php

namespace Database\Seeders;

use App\models\Surah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use NunoMaduro\Collision\Adapters\Phpunit\State;
use Illuminate\Support\Facades\DB;


class SurahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Surah::unguard();
        // $surahSqlPath = public_path('../database/data/surah.sql');
        // DB::unprepared(file_get_contents($surahSqlPath));
        // Drop the foreign key constraint in the other table
        // $dropForeignKey = "
        //     ALTER TABLE `ayah`
        //         DROP FOREIGN KEY `ayah_surah_id_foreign`;
        // ";

        // try {
        //     DB::unprepared($dropForeignKey);
        // } catch (\Exception $e) {
        //     $this->command->info('Error occurred while dropping foreign key: ' . $e->getMessage());
        // }

        // // Modify the column to be AUTO_INCREMENT
        // $modifyColumn = "
        //     ALTER TABLE `surah`
        //         MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;
        // ";

        // try {
        //     DB::unprepared($modifyColumn);
        // } catch (\Exception $e) {
        //     $this->command->info('Error occurred while modifying column: ' . $e->getMessage());
        // }

        Surah::truncate();
  
        $csvFile = fopen(base_path("database/data/csv/surat.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Surah::create([
                    "id" => $data['0'],
                    "name_en" => $data['1'],
                    "name_ar" => $data['2'],
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}

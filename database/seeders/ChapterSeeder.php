<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Chapter;


class ChapterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Chapter::truncate();

        $csvFile = fopen(base_path("database/data/ahadith/hadith_chapter.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Chapter::create([
                    "chapter_id" => $data['1'],
                    "imam_id" => $data['0'],
                    "chapter_text" => $data['2'],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SurahSeeder::class);
        $this->call(AyahSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(FeedbackSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(DonationSeeder::class);
        $this->call(MailingSeeder::class);
        $this->call(QuranInformationSeeder::class);

    }
}

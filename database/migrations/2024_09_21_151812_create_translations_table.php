<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ayahs', function (Blueprint $table) {
            $table->id(); // This creates an unsignedBigInteger column as primary key
            $table->unsignedBigInteger('surah_id'); // Foreign key to the Surah
            $table->integer('ayah_number');
            $table->timestamps();
        
            // Foreign key constraint
            $table->foreign('surah_id')->references('id')->on('surahs')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('translations');
    }
};

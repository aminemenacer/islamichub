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
        Schema::create('correction', function (Blueprint $table) {
            $table->id();
            $table->string('spelling_mistakes')->nullable();
            $table->string('incomplete_text')->nullable();
            $table->string('translation_error')->nullable();
            $table->string('added_notes')->nullable();
            $table->string('reference_error')->nullable();
            $table->string('narrator')->nullable();
            $table->string('hadith_english')->nullable();
            $table->string('hadith_arabic')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('correction');
    }
};

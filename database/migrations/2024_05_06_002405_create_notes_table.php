<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('surah_name')->nullable();
            $table->text('ayah_num')->nullable();
            $table->text('ayah_info')->nullable();
            $table->text('ayah_verse_ar')->nullable();
            $table->text('ayah_verse_en')->nullable();
            $table->text('ayah_notes')->nullable();
            $table->timestamps();

            // Assuming 'id' is the primary key of the users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }
}


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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('lastname')->nullable();
            $table->string('phone')->nullable();
            $table->string('user_type')->nullable();
            $table->string('status')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('subscribe')->nullable();
            $table->string('role')->default('user'); // default role is 'user'
            $table->string('google_id')->nullable();
            $table->string('fb_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Ubah nama kolom menjadi user_id
            $table->unsignedBigInteger('followed_id'); // Ubah nama kolom menjadi followed_id
            $table->boolean('status')->default(false); // Ubah default menjadi false
            $table->timestamps();

            // Tambahkan foreign key constraint untuk menghubungkan kolom user_id dengan kolom id di tabel users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // Tambahkan foreign key constraint untuk menghubungkan kolom followed_id dengan kolom id di tabel users
            $table->foreign('followed_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followers');
    }
};

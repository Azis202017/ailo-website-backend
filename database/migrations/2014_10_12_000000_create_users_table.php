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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('kode_asistant')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('tahun_asistant')->nullable();
            $table->string('foto')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('github')->nullable();
            $table->string('discord')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('kategori_asistant')->nullable();
            $table->enum('is_assistant',['dosen','mahasiswa'])->nullable();
            $table->string('biography')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

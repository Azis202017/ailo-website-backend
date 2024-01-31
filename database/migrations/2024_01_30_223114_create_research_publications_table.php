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
        Schema::create('research_publications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_research_area');
            $table->string('title');
            $table->string('description');
            $table->string('publish_year');
            $table->string('link_publication');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research_publications');
    }
};

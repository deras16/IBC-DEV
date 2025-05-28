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
        Schema::create('case_studies', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->enum('space_topic', ['Ai', 'Memecoin','Defi','RWA','Gaming','NFT','Web3','SocialFi','Countdown']);
            $table->enum('space_type', ['SS on M', 'Video on M', 'SS on RT', 'Video on RT']);
            $table->string('space_title');
            $table->date('date');
            $table->string('client_twitter_username')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_studies');
    }
};

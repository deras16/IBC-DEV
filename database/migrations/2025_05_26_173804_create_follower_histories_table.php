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
        Schema::create('follower_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('follower_count')->default(0)->nullable(false);
            $table->date('loaded_at')->default(now())->nullable(false);
            $table->morphs('followable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follower_histories');
    }
};

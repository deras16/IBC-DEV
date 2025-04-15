<?php

use App\Enums\MarketingTopic;
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
        Schema::create('marketing_case_studies', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->text('client_description');
            $table->enum('marketing_case_topic', ['Sports & Life Style', 'Music Streaming', 'Travel & Hospitality', 'Food & Beverage', 'Health & Wellness', 'Fashion & Beauty', 'Technology & Gadgets', 'Entertainment & Media', 'Automotive', 'Finance & Banking']);
            $table->date('date');
            $table->bigInteger('views');
            $table->bigInteger('impressions');
            $table->bigInteger('listeners');
            $table->bigInteger('followers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketing_case_studies');
    }
};

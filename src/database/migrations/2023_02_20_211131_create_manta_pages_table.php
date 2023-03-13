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
        Schema::create('manta_pages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('added_by')->nullable();
            $table->string('changed_by')->nullable();
            $table->integer('company_id')->nullable();
            $table->string('host')->nullable();
            $table->string('locale')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->longText('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->boolean('fixed')->nullable();   // Used when text is fixed in website
            $table->boolean('fullpage')->nullable();   // Can be used as standalone page
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manta_pages');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id');
            $table->foreignId('region_id');
            $table->foreignId('category_id');
            $table->foreignId('photo_id');
            $table->foreignId('opinions_id');
            $table->string('title');
            $table->mediumText('anons');
            $table->longText('text');
            $table->integer('flags');
            $table->jsonb('author');
            $table->jsonb('tags');
            $table->jsonb('extensions');
            $table->timestamp('published_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};

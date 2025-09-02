<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            // User relation
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Category relation (може бути null, якщо пост без категорії)
            $table->foreignId('category_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');

            // Post data
            $table->string('title');
            $table->text('content');

            // Optional image
            $table->string('image')->nullable();

            // Auto timestamps
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};

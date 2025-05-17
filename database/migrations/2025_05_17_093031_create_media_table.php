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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('caption')->nullable();
            $table->string('filename')->nullable(); // Untuk file lokal
            $table->string('url');                  // Lokal atau eksternal
            $table->enum('type', ['image', 'video', 'external'])->default('image');
            $table->string('provider')->nullable(); // YouTube, Vimeo, dll
            $table->string('thumbnail')->nullable();
            $table->foreignId('artikel_id')->nullable()->constrained('artikels')->onDelete('cascade'); // opsional
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('order')->default(0);
            $table->json('metadata')->nullable(); // resolusi, ukuran, dll
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};

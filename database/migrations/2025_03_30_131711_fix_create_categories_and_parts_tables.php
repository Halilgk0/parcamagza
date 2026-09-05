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
        // Categories tablosunu oluştur
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->string('icon')->nullable();
                $table->string('image')->nullable();
                $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('set null');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
        
        // Parts tablosunu oluştur
        if (!Schema::hasTable('parts')) {
            Schema::create('parts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('category_id')->constrained()->onDelete('cascade');
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('part_number')->unique();
                $table->text('description');
                $table->decimal('price', 10, 2);
                $table->integer('stock_quantity')->default(0);
                $table->string('condition')->default('new'); // new, used, refurbished
                $table->string('image')->nullable();
                $table->json('specifications')->nullable();
                $table->json('compatibility')->nullable(); // Store compatible car models
                $table->string('manufacturer')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parts');
        Schema::dropIfExists('categories');
    }
};

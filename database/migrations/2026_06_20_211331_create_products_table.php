<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name_fr');
            $table->string('name_en');
            $table->string('slug')->unique();
            $table->text('description_fr')->nullable();
            $table->text('description_en')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->json('images')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

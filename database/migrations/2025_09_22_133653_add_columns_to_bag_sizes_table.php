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
        Schema::table('bag_sizes', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->decimal('weight', 8, 2)->after('name'); // Weight in kg
            $table->decimal('price', 8, 2)->after('weight'); // Price in £
            $table->boolean('is_active')->default(true)->after('price');
            $table->integer('sort_order')->default(0)->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bag_sizes', function (Blueprint $table) {
            $table->dropColumn(['name', 'weight', 'price', 'is_active', 'sort_order']);
        });
    }
};

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
        Schema::create('formulir_domains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formulir_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('domain_id')->constrained()->onDelete('cascade ')->onUpdate('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulir_domains');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('peserta_penjadwalans', function (Blueprint $table) {
    //         $table->id();
    //         $table->unsignedBigInteger('penjadwalan_id');
    //         $table->unsignedBigInteger('peserta_id');


    //         $table->text('ringkasan_pembinaan');
    //         $table->text('bukti_pembinaan');
    //         $table->text('pemateri');

    //         $table->softDeletes();
    //         $table->timestamps();


    //         $table->foreign('penjadwalan_id')->references('id')->on('penjadwalans')->onDelete('cascade')->onUpdate('cascade');
    //         $table->foreign('peserta_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::dropIfExists('peserta_pembinaans');
    // }
};

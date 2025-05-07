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
        Schema::create('archives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('bidang_id')->nullable();
            $table->integer('seksi_id')->nullable();
            $table->integer('kategori_id')->nullable();
            $table->date('tanggal_arsip');
            $table->string('nama_arsip');
            $table->string('nomor_arsip');
            $table->longText('keterangan_arsip');
            $table->string('cover_arsip');
            $table->string('arsip_file')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archives');
    }
};

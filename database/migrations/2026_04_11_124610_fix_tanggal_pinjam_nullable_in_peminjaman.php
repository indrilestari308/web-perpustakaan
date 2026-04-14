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
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->date('tanggal_pinjam')->nullable()->change();
            $table->date('batas_kembali')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->date('tanggal_pinjam')->nullable(false)->change();
            $table->date('batas_kembali')->nullable(false)->change();
        });
    }
};

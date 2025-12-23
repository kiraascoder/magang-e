<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jurnal_pekans', function (Blueprint $table) {
            $table->id('id_jurnal_pekan');

            $table->unsignedBigInteger('id_penempatan');
            $table->unsignedBigInteger('id_mhs'); // users.id (mahasiswa)

            $table->unsignedInteger('pekan_ke');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();

            $table->unsignedInteger('total_menit')->default(0);

            $table->enum('status', ['draft', 'terkirim', 'disetujui', 'ditolak'])->default('draft');
            $table->text('catatan_mentor')->nullable();

            $table->timestamps();

            $table->foreign('id_penempatan')
                ->references('id_penempatan')->on('penempatans')
                ->cascadeOnUpdate()->restrictOnDelete();

            $table->foreign('id_mhs')
                ->references('id')->on('users')
                ->cascadeOnUpdate()->restrictOnDelete();

            $table->unique(['id_penempatan', 'pekan_ke'], 'uniq_penempatan_pekan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurnal_pekans');
    }
};

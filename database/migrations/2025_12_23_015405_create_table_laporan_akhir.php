<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laporan_akhirs', function (Blueprint $table) {
            $table->id('id_laporan_akhir');

            $table->unsignedBigInteger('id_penempatan');
            $table->unsignedBigInteger('id_mhs');

            $table->string('judul')->nullable();
            $table->string('file_path'); // simpan path file di storage
            $table->string('original_name')->nullable();
            $table->unsignedBigInteger('file_size')->default(0);
            $table->string('mime')->nullable();

            $table->enum('status', ['draft', 'terkirim', 'disetujui', 'ditolak'])->default('draft');
            $table->text('catatan_mentor')->nullable();

            $table->timestamps();

            $table->foreign('id_penempatan')
                ->references('id_penempatan')->on('penempatans')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('id_mhs')
                ->references('id')->on('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // 1 laporan akhir per penempatan (opsional, biar rapi)
            $table->unique(['id_penempatan'], 'uniq_laporan_per_penempatan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_akhirs');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id('id_logbook');

            $table->unsignedBigInteger('id_penempatan');
            $table->unsignedBigInteger('id_mhs');

            $table->date('tanggal');
            $table->text('kegiatan');

            // simpan path file (contoh: logbooks/xxx.jpg/pdf)
            $table->string('dokumentasi')->nullable();

            // status alur logbook
            $table->enum('status', ['draft', 'terkirim', 'disetujui', 'ditolak'])->default('draft');

            // catatan dari dosen mentor
            $table->text('catatan_mentor')->nullable();

            $table->timestamps();

            // FK ke penempatans
            $table->foreign('id_penempatan')
                ->references('id_penempatan')->on('penempatans')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            // FK ke users (mahasiswa)
            $table->foreign('id_mhs')
                ->references('id')->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            // Index untuk query cepat
            $table->index(['id_mhs', 'tanggal'], 'idx_logbook_mhs_tanggal');
            $table->index(['id_penempatan', 'tanggal'], 'idx_logbook_penempatan_tanggal');

            // Opsional: cegah input dobel pada tanggal yang sama untuk 1 penempatan
            $table->unique(['id_penempatan', 'tanggal'], 'uniq_logbook_penempatan_tanggal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logbooks');
    }
};

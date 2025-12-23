<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('periodes', function (Blueprint $table) {
            $table->id('id_periode');

            $table->string('nama_periode', 150);
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');

            $table->enum('status', ['aktif', 'selesai', 'nonaktif'])->default('nonaktif');
            $table->string('keterangan', 255)->nullable();

            $table->timestamps();

            // opsional: mencegah duplikasi nama periode yang sama
            // $table->unique('nama_periode');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periodes');
    }
};

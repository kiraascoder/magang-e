<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jurnal_harians', function (Blueprint $table) {
            $table->id('id_jurnal_harian');

            $table->unsignedBigInteger('id_jurnal_pekan');
            $table->date('tanggal');

            $table->time('jam_datang')->nullable();
            $table->time('jam_pulang')->nullable();

            $table->unsignedInteger('jumlah_menit')->default(0);
            $table->text('kegiatan')->nullable();

            $table->timestamps();

            $table->foreign('id_jurnal_pekan')
                ->references('id_jurnal_pekan')->on('jurnal_pekans')
                ->cascadeOnUpdate()->cascadeOnDelete();

            $table->unique(['id_jurnal_pekan', 'tanggal'], 'uniq_pekan_tanggal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurnal_harians');
    }
};

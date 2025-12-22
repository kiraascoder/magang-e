<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penempatans', function (Blueprint $table) {
            $table->id('id_penempatan');            
            $table->unsignedBigInteger('id_mhs');
            $table->unsignedBigInteger('id_dosen_mentor');
            $table->unsignedBigInteger('id_admin');

            $table->unsignedBigInteger('id_instansi');
            $table->unsignedBigInteger('id_periode');

            $table->string('divisi')->nullable();
            $table->string('posisi')->nullable();
            $table->string('lokasi')->nullable();

            $table->date('tgl_mulai')->nullable();
            $table->date('tgl_selesai')->nullable();

            $table->enum('status', ['draft', 'aktif', 'selesai', 'batal'])->default('draft');

            $table->timestamps();            
            $table->foreign('id_mhs')
                ->references('id')->on('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('id_dosen_mentor')
                ->references('id')->on('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('id_admin')
                ->references('id')->on('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // FK lain
            $table->foreign('id_instansi')
                ->references('id_instansi')->on('instansis')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('id_periode')
                ->references('id_periode')->on('periodes')
                ->cascadeOnUpdate()
                ->restrictOnDelete();            
            $table->unique(['id_mhs', 'id_periode'], 'uniq_mhs_periode');            
            $table->index(['id_dosen_mentor', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penempatans');
    }
};

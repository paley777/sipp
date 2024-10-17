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
        Schema::create('faults', function (Blueprint $table) {
            $table->id();
            $table->string('id_student');
            $table->string('nama');
            $table->string('nisn');
            $table->string('kelas');
            $table->string('nama_ortu');
            $table->longText('alamat');
            $table->string('no_hp');
            $table->string('pelanggaran');
            $table->integer('poin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faults');
    }
};

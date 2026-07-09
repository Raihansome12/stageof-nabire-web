<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permohonan_data', function (Blueprint $table) {
            $table->id();

            // Identitas pemohon
            $table->string('nama_lengkap');
            $table->string('nik', 16)->nullable();
            $table->string('email')->nullable();
            $table->string('no_hp', 20);
            $table->string('instansi');
            $table->text('alamat')->nullable();

            // Permohonan
            $table->enum('jenis_permohonan', ['pnbp', 'nol']); // PNBP atau Tarif Nol Rupiah
            $table->string('jenis_data');                        // Jenis data yang diminta
            $table->string('lingkup_kegiatan')->nullable();       // Untuk tarif nol rupiah

            // Dokumen pendukung (path ke storage)
            $table->string('file_surat_permohonan')->nullable();
            $table->string('file_surat_pengantar')->nullable();
            $table->string('file_surat_pernyataan')->nullable();
            $table->string('file_proposal')->nullable();

            // Status pengelolaan
            $table->enum('status', ['baru', 'diproses', 'selesai', 'ditolak'])->default('baru');
            $table->text('catatan_admin')->nullable();

            // Laporan penyelesaian (diisi admin saat status diubah ke "selesai")
            $table->json('dokumen_terkirim')->nullable();
            $table->timestamp('selesai_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonan_data');
    }
};

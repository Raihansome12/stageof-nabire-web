<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permohonan_data', function (Blueprint $table) {
            // Admin yang sedang/terakhir menangani permohonan ini. Diperbarui setiap
            // kali status berubah, sehingga jika terjadi pergantian petugas di tengah
            // proses, selalu jelas siapa penanggung jawab saat ini.
            // Informasi ini HANYA untuk kebutuhan internal admin panel — tidak pernah
            // ditampilkan pada PDF Detail Pemohon maupun Laporan Selesai.
            $table->foreignId('admin_penanggung_jawab_id')
                ->nullable()
                ->after('catatan_admin')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('permohonan_data', function (Blueprint $table) {
            $table->dropConstrainedForeignId('admin_penanggung_jawab_id');
        });
    }
};

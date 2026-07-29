<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permohonan_data', function (Blueprint $table) {
            // Nama petugas yang mengisi form saat perubahan terakhir — diisi manual,
            // karena panel admin memakai satu akun login bersama sehingga
            // admin_penanggung_jawab_id tidak cukup untuk identifikasi personal.
            $table->string('admin_penanggung_jawab_nama')->nullable()->after('admin_penanggung_jawab_id');
        });
    }

    public function down(): void
    {
        Schema::table('permohonan_data', function (Blueprint $table) {
            $table->dropColumn('admin_penanggung_jawab_nama');
        });
    }
};

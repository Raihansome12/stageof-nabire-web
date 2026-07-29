<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permohonan_data_logs', function (Blueprint $table) {
            // Admin panel hanya memakai satu akun login bersama ("Admin"), sehingga
            // admin_id saja tidak cukup untuk mengetahui siapa yang benar-benar
            // menangani. Petugas mengisi namanya sendiri secara manual setiap kali
            // mengubah status, dan nama itulah yang disimpan di sini.
            $table->string('nama_petugas')->nullable()->after('admin_id');
        });
    }

    public function down(): void
    {
        Schema::table('permohonan_data_logs', function (Blueprint $table) {
            $table->dropColumn('nama_petugas');
        });
    }
};

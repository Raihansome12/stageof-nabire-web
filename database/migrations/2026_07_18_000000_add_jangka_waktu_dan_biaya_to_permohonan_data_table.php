<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permohonan_data', function (Blueprint $table) {
            // Diisi oleh admin: estimasi jangka waktu penyelesaian & biaya/tarif
            // yang dikenakan kepada pemohon. Ditampilkan pada PDF Detail Pemohon.
            $table->string('jangka_waktu_penyelesaian')->nullable()->after('catatan_admin');
            $table->string('biaya_tarif')->nullable()->after('jangka_waktu_penyelesaian');
        });
    }

    public function down(): void
    {
        Schema::table('permohonan_data', function (Blueprint $table) {
            $table->dropColumn(['jangka_waktu_penyelesaian', 'biaya_tarif']);
        });
    }
};

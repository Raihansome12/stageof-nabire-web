<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permohonan_data_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('permohonan_data_id')
                ->constrained('permohonan_data')
                ->cascadeOnDelete();

            // Perubahan status yang tercatat (mis. baru -> diproses -> sudah dibayar -> selesai)
            $table->string('status_sebelumnya')->nullable();
            $table->string('status_baru');

            // Admin yang melakukan perubahan status ini
            $table->foreignId('admin_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('catatan')->nullable();

            $table->timestamps();

            $table->index(['permohonan_data_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonan_data_logs');
    }
};

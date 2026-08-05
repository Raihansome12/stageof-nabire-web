<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Part of the fix for security review finding #6 (NIK stored as plaintext).
 *
 * The `nik` column was VARCHAR(16), sized for a raw 16-digit Indonesian
 * national ID number. Once the model casts `nik` to `encrypted`, Eloquent
 * stores base64-encoded, encrypted ciphertext instead — which is far longer
 * than 16 characters and would be silently truncated by the DB. This widens
 * the column to TEXT first so no data is lost.
 *
 * NOTE: if this app already has PRODUCTION rows with plaintext NIK values,
 * simply adding the `encrypted` cast to the model will NOT retroactively
 * encrypt them, and reading an old plaintext row through the new cast will
 * throw a decryption exception. Before deploying this migration + cast to an
 * environment with existing data, re-save each row once through Eloquent
 * (e.g. a one-off `php artisan tinker` loop calling `$row->save()` after
 * setting `$row->nik = $row->getRawOriginal('nik')`) so the cast encrypts the
 * existing value on write. This repo's own database is empty, so no such
 * migration script was needed here.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permohonan_data', function (Blueprint $table) {
            $table->text('nik')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('permohonan_data', function (Blueprint $table) {
            $table->string('nik', 16)->nullable()->change();
        });
    }
};

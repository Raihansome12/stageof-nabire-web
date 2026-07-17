<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('earthquakes', function (Blueprint $table) {
            // "Siaran Pers" — long-form press-release text shown on the
            // earthquake detail page (pages.earthquake-show).
            $table->longText('description')->nullable()->after('shakemap_image');
        });
    }

    public function down(): void
    {
        Schema::table('earthquakes', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};

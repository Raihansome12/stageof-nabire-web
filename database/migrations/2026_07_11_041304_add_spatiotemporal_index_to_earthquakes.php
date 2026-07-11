<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('earthquakes', function (Blueprint $table) {
            $table->index(['occurred_at', 'latitude', 'longitude'], 'spatiotemporal_index');
        });
    }

    public function down()
    {
        Schema::table('earthquakes', function (Blueprint $table) {
            $table->dropIndex('spatiotemporal_index');
        });
    }
};
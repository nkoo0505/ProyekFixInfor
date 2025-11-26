<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ormawa', function (Blueprint $table) {
            $table->string('periode', 50)->nullable()->after('role');
        });
    }

    public function down()
    {
        Schema::table('ormawa', function (Blueprint $table) {
            $table->dropColumn('periode');
        });
    }
};

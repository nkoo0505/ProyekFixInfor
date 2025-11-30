<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('ormawa') && !Schema::hasColumn('ormawa', 'highlight_image')) {
            Schema::table('ormawa', function (Blueprint $table) {
                $table->string('highlight_image')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('ormawa') && Schema::hasColumn('ormawa', 'highlight_image')) {
            Schema::table('ormawa', function (Blueprint $table) {
                $table->dropColumn('highlight_image');
            });
        }
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('ormawa') && !Schema::hasColumn('ormawa', 'highlight_gallery')) {
            Schema::table('ormawa', function (Blueprint $table) {
                $table->text('highlight_gallery')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('ormawa') && Schema::hasColumn('ormawa', 'highlight_gallery')) {
            Schema::table('ormawa', function (Blueprint $table) {
                $table->dropColumn('highlight_gallery');
            });
        }
    }
};

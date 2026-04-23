<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('payments') || Schema::hasColumn('payments', 'bukti_path')) {
            return;
        }

        Schema::table('payments', function (Blueprint $table) {
            $table->string('bukti_path')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('payments') || !Schema::hasColumn('payments', 'bukti_path')) {
            return;
        }

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('bukti_path');
        });
    }
};

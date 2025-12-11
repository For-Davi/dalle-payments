<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments_dalle_manage', function (Blueprint $table) {
            $table->string('pix_qr_code_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('payments_dalle_manage', function (Blueprint $table) {
            $table->dropColumn('pix_qr_code_id');
        });
    }
};

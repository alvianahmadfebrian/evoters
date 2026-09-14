<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->text('qr_image')->nullable()->after('payment_url');
            $table->text('qr_string')->nullable()->after('qr_image');
            $table->timestamp('payment_expired_at')->nullable()->after('qr_string');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->dropColumn(['qr_image', 'qr_string', 'payment_expired_at']);
        });
    }
};

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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('coupon_id')
                ->nullable()
                ->after('total_price')
                ->constrained('coupons')
                ->nullOnDelete();

            $table->string('coupon_code')->nullable()->after('coupon_id');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('coupon_code');
            $table->decimal('final_price', 10, 2)->default(0)->after('discount_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['coupon_id']);
            $table->dropColumn([
                'coupon_id',
                'coupon_code',
                'discount_amount',
                'final_price'
            ]);
        });
    }
};

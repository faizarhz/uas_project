<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $t) {
            $t->id();
            $t->string('number')->unique();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->string('customer_name');
            $t->string('email')->nullable();
            $t->string('phone', 20);
            $t->string('address');
            $t->string('city');
            $t->string('province');
            $t->string('postal', 10);
            $t->string('ship');
            $t->string('pay');
            $t->unsignedBigInteger('subtotal');
            $t->unsignedBigInteger('shipping_cost');
            $t->unsignedBigInteger('total');
            $t->string('status')->default('pending'); // pending, paid, cod, failed, expired, cancelled, refunded
            $t->string('payment_type')->nullable();
            $t->string('snap_token')->nullable();
            $t->json('items');
            $t->timestamp('paid_at')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->tinyInteger('package_id')->unsigned();
            $table->string('customer_name', 100);
            $table->string('customer_phone', 20);
            $table->string('customer_email', 150)->nullable();
            $table->string('source', 20)->default('wa')->comment('wa, shopee, langsung');
            $table->string('shopee_order_id', 100)->nullable();
            $table->unsignedInteger('amount')->default(0)->comment('Nominal dalam rupiah');
            $table->string('status', 20)->default('pending')->comment('pending, paid, processed, done, cancelled');
            $table->text('notes')->nullable()->comment('Catatan dari klien atau admin');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->foreign('package_id')->references('id')->on('packages')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('bill_number')->nullable();
            $table->string('shop_name');
            $table->string('shop_address')->nullable();
            $table->string('shop_phone')->nullable();
            $table->date('bill_date');
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->enum('payment_method', ['cash', 'credit', 'card'])->default('cash');
            $table->string('responsible_person')->nullable();
            $table->text('note')->nullable();
            $table->enum('status', ['active', 'cancelled'])->default('active');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();

            // Indexes for better performance
            $table->index('bill_date');
            $table->index('shop_name');
            $table->index('status');
            $table->index('payment_method');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bills');
    }
};

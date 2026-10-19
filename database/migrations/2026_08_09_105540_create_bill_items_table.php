<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bill_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id')->constrained()->onDelete('cascade');
            $table->string('item_name');
            $table->string('category')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 15, 2)->default(0);
            $table->decimal('total_price', 15, 2)->default(0);
            $table->text('description')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index('item_name');
            $table->index('category');
            $table->index('bill_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bill_items');
    }
};
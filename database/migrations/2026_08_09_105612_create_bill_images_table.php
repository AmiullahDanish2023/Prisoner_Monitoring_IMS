<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bill_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->string('image_name');
            $table->boolean('is_primary')->default(false);
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index('bill_id');
            $table->index('is_primary');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bill_images');
    }
};

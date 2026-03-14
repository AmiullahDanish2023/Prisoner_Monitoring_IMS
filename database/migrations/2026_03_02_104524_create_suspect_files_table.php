<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuspectFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suspect_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('suspect_id')->constrained()->onDelete('cascade');
            $table->string('file_path');
            $table->enum('file_type', ['suspect', 'release']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suspect_files');
    }
}

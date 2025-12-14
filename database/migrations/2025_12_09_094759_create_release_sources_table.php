<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReleaseSourcesTable extends Migration
{
    public function up()
    {
        Schema::create('release_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name_da');
            $table->string('name_pa')->nullable(); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('release_sources');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuspectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suspects', function (Blueprint $table) {
            $table->id();
            $table->string('gender')->nullable();
            $table->string('suspect_name');
            $table->string('father_name');
            $table->string('grandfather_name')->nullable();
            $table->integer('children_with_mother')->nullable();
            $table->string('crime_type');
            $table->string('referring_authority')->nullable();
            $table->date('monitoring_date');
            $table->integer('province');
            $table->string('district')->nullable();
            $table->string('area')->nullable();
            $table->string('file')->nullable();
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
        Schema::dropIfExists('suspects');
    }
}

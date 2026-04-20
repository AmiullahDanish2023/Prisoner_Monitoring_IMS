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
            $table->string('gender');
            $table->string('suspect_name');
            $table->string('father_name');
            $table->string('grandfather_name')->nullable();
            $table->string('children_with_mother')->nullable();
            $table->string('crime_type');
            $table->string('referring_authority')->nullable();
            $table->date('monitoring_date');
            $table->integer('province');
            $table->string('district')->nullable();
            $table->string('area')->nullable();
            $table->boolean('has_items')->nullable();
            $table->string('file')->nullable();
            $table->enum('status', ['prisoner', 'released'])->default('prisoner');
            $table->timestamps();


            // add indexingt to the columns that are frequently searched
            $table->index('id');
            $table->index('gender');
            $table->index('suspect_name');
            $table->index('father_name');
            $table->index('crime_type');
            $table->index('province');
            $table->index('monitoring_date');
            $table->index('referring_authority');



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

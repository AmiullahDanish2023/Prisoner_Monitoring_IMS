<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReleaseSuspectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('release_suspects', function (Blueprint $table) {


            $table->id();

            $table->foreignId('suspect_id')
                ->constrained('suspects')
                ->onDelete('cascade');
            $table->string('main_option_key');
            $table->string('db_source_name')->nullable();
            $table->string('issued_or_transferred_number');
            $table->string('release_date');
            $table->string('file')->nullable();

            $table->enum('items_status', ['confiscated', 'not_confiscated'])->nullable();
            $table->integer('release_source_id');
                
               



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
        Schema::table('release_suspects', function (Blueprint $table) {
            $table->dropForeign(['release_source_id']);
            $table->dropColumn('release_source_id');
        });
    }
}

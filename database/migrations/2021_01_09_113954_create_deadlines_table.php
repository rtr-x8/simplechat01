<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeadlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deadlines', function (Blueprint $table) {
            $table->uuid('deadline_id')->primary();
            $table->uuid('liner_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('is_active');
            $table->boolean('is_complete');
            $table->dateTime('deadline_at');
            $table->timestamps();

            // fk
            $table->foreign('liner_id', 'deadlines_fk1')
                ->references('liner_id')
                ->on('liners')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deadlines', function (Blueprint $table) {
            $table->dropForeign('deadlines_fk1');
            $table->dropIfExists();
        });
    }
}

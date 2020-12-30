<?php

use CountDownChat\Domain\Liner\LinerSourceType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liners', function (Blueprint $table) {
            $table->uuid('liner_id')->primary();
            $table->enum('source_type', LinerSourceType::getValues())
                ->comment("1:ユーザー,2:グループ,3:トークルーム");
            $table->string('provided_liner_id')->unique();
            $table->boolean('is_active');
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
        Schema::dropIfExists('liners');
    }
}

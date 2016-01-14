<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('is_single_use')->default(true);
            $table->string('email');
            $table->timestamp('valid_until')->index();
            $table->string('object_action')->nullable();
            $table->unsignedBigInteger('object_id')->nullable();
            $table->string('object_type')->nullable();
            $table->string('token');
            $table->timestamps();
            $table->softDeletes();

            $table->unique('email', 'token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('access_tokens');
    }
}

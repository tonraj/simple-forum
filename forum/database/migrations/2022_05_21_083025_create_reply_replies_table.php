<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReplyRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reply_replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reply_id');
            $table->foreign('reply_id')->references('id')->on('reply');
            $table->enum('status', ['Pending', 'Approved']);
            $table->string('content');
            $table->string('name');
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
        Schema::dropIfExists('reply_replies');
    }
}

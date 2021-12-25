<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_headers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('trans_no')->unique();
            $table->date('trans_date');
            $table->integer('qty');
            $table->float('cost');
            $table->text('comments')->nullable();
            $table->string('invo_no')->nullable();
            $table->date('invo_date')->nullable();
            $table->integer('from')->index()->nullable();
            $table->integer('to')->index();
            $table->integer('transfer_type_id')->index();
            $table->integer('user_id')->index();
            $table->integer('client_id')->index()->nullable();
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
        Schema::dropIfExists('transfer_headers');
    }
}

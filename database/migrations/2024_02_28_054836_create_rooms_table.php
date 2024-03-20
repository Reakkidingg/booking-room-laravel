<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id('room_id');
            $table->string('room_name')->unique();
            $table->string('room_desc')->nullable();
            $table->enum('room_status', ['0','1'])->default(1);
            $table->timestamps();

            $table->unsignedBigInteger('room_type_id');

            $table->foreign('room_type_id')
                    ->references('room_type_id')
                    ->on('room_types')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
};

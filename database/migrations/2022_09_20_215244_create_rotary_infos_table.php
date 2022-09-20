<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('rotary_infos', function (Blueprint $table) {
            $table->id();

            $table->string('host_club')->nullable();
            $table->string('host_district')->nullable();
            $table->string('sponsor_club')->nullable();
            $table->string('sponsor_district')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rotary_infos');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('journalists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->text('biography')->nullable();
            $table->timestamps();
            $table->foreign('email')->references('email')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('journalists');
    }
};

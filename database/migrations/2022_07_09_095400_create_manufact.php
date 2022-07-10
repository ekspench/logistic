<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManufact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("part", function (Blueprint $table) {
            $table->id();
            $table->string("reference");
            $table->integer("max_cast")->default(20);
            $table->timestamps();
        });
        Schema::create("box", function (Blueprint $table) {
            $table->id();
            $table->string("numero");
            $table->string("ref")->nullable();
            $table->boolean("is_valid")->default(false);
            $table->timestamp(("control_at"))->nullable();
            $table->unsignedBigInteger("part_id");
            $table->foreign("part_id")->on("part")->references("id");
            $table->unsignedBigInteger("user_id")->nullable();
            $table->foreign("user_id")->on("users")->references("id");
            $table->timestamps();
        });
        Schema::create("cast", function (Blueprint $table) {
            $table->id();
            $table->string("mark");
            $table->unsignedBigInteger("box_id");
            $table->foreign("box_id")->on("box")->references("id");
            $table->integer("number")->nullable();
            $table->string("status")->default("pending");
            $table->string("mark_replace")->nullable();
            $table->boolean("is_control")->default(false);
            $table->timestamp("control_at")->nullable();
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
        Schema::dropIfExists('manufact');
    }
}

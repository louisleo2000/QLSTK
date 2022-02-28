<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->integer('family_tree_id')->unsigned();
            $table->string('name');
            $table->date('dob')->nullable();
            $table->date('dod')->nullable();
            $table->string('gender')->default('male');
            $table->string('img')->nullable();
            $table->integer('father_id')->nullable();
            $table->integer('mother_id')->nullable();
            $table->string('couple_id')->nullable();
            $table->timestamps();
            $table->foreign('family_tree_id')
            ->references('id')->on('family_trees')
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
        Schema::dropIfExists('members');
    }
}

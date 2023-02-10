<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->integer('group_mentor');
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->text('details')->nullable();
            $table->integer('group_type')->nullable();
            $table->integer('days')->nullable();
            $table->double('price',28,8)->default(0.00000000);
            $table->integer('post_permisison')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('groups');
    }
}

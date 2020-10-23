<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('family_id')->unsigned();
			$table->string('name');
			$table->string('slug')->nullable();
			$table->string('description')->nullable();
			$table->text('cover_photo_path')->nullable();
			$table->boolean('editable')->default(true);
			$table->boolean('duplicate_check')->default(true);
            $table->timestamps();

			$table->foreign('family_id')
                ->references('id')
                ->on('families')
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
        Schema::dropIfExists('albums');
    }
}

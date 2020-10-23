<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('photo_id')->unsigned();
            $table->integer('member_id')->unsigned();
			$table->integer('left');
			$table->integer('top');
            $table->timestamps();

			$table->foreign('photo_id')
                ->references('id')
                ->on('photos')
                ->onDelete('cascade');

			$table->foreign('member_id')
				->references('id')
				->on('members')
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
        Schema::dropIfExists('photos_tags');
    }
}

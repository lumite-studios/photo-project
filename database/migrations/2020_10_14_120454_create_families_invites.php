<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamiliesInvites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('families_invites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('family_id')->unsigned();
			$table->string('email')->index();
			$table->string('code');
			$table->json('permissions')->nullable();
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
        Schema::dropIfExists('families_invites');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationColumnsToMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function(Blueprint $table)
        {
			$table->date('birthday')->nullable();
            $table->integer('mother_id')->unsigned()->nullable();
            $table->integer('father_id')->unsigned()->nullable();

			$table->foreign('mother_id')
				->references('id')
				->on('members');
			$table->foreign('father_id')
				->references('id')
				->on('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function(Blueprint $table)
        {
			$table->dropForeign(['mother_id', 'father_id']);
            $table->dropColumn('birthday');
            $table->dropColumn('mother_id');
            $table->dropColumn('father_id');
        });
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewsNews extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
			Schema::create('news',function(Blueprint $table){
			$table->increments('id');
		    $table->integer('feed_id')->unsigned()->index();
            $table->foreign('feed_id')->references('id')->on('finalfeeds')->onDelete('cascade');
            $table->boolean('lock');
            $table->string('title')->unique();
            $table->text('description');
            $table->text('search_column');
            $table->text('imglink');
            $table->text('link');
            $table->timestamp('date')->nullable();
			$table->timestamp('created_at')->nullable();
			$table->timestamp('updated_at')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('news');
	}

}

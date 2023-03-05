<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_author');
            $table->string('post_title');
            $table->string('post_slug', 100)->unique();
            $table->string('post_type')->default('post');
            $table->string('excerpt', 100)->nullable();
            $table->longText('post_content')->nullable();
            $table->string('post_status', 20);
            $table->integer('comment_count')->default(0);
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
        Schema::dropIfExists('posts');
    }
};

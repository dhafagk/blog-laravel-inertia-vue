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
            $table->string('title', 100);
            $table->string('slug');
            $table->string('post_type');
            $table->integer('status');
            $table->text('body');
            $table->string('featured_image')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreignID('user_id')->constrained();
            $table->index('slug');
            $table->index(['created_at', 'updated_at']);
            $table->index('post_type');
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

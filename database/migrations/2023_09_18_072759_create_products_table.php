<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('title');
            $table->string('sub_title')->nullable();
            $table->tinyText('short_description')->nullable();
            $table->text('content')->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('featured_image_id')->nullable();
            $table->bigInteger('banner_image_id')->nullable();
            $table->bigInteger('icon_image_id')->nullable();
            $table->string('browser_title')->nullable();
            $table->string('og_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('og_description')->nullable();
            $table->bigInteger('og_image_id')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('bottom_description')->nullable();
            $table->text('extra_js')->nullable();
            $table->integer('priority')->default(0);
            $table->boolean('is_featured')->default(0);
            $table->boolean('status')->default(1);
            $table->boolean('list_in_home_about')->default(0);
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->useCurrent();
            $table->dateTime('deleted_at')->nullable();
        });

        Schema::create('product_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('blogs_id');
            $table->bigInteger('tags_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_tags');
        Schema::dropIfExists('products');
    }
};

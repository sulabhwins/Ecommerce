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
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->unsignedBigInteger('vender_id');
            $table->string('name');
            $table->string('color');
            $table->string('titel');
            $table->text('description');
            $table->float('saling_price');
            $table->string('product_image')->nullable();
            $table->integer('quintity');
            // $table->string('url');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_keywords');
            $table->enum('isfeatured',['NO','yes']);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('subcategory_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('vender_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
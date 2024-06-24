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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->text('content');
            $table->integer('rating');
            $table->unsignedBigInteger('checkout_id');
            $table->string('produk_id'); // Ubah tipe data sesuai kebutuhan, bisa juga text atau json
            $table->timestamps();
 
            $table->foreign('checkout_id')->references('id')->on('checkout')->onDelete('null');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('null');
        });
    }
 
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
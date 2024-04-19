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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->integer('subkategori_id');
            $table->string('nama_barang');
            $table->string('gambar');
            $table->text('deskripsi');
            $table->integer('harga');
            $table->integer('diskon');
            $table->string('bahan');
            $table->string('tags');
            $table->string('sku');
            $table->string('ukuran');
            $table->string('warna');
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
        Schema::dropIfExists('produks');
    }
};

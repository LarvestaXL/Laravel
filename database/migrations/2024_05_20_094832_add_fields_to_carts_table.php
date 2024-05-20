<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->string('gambar')->nullable()->after('member_id');
            $table->string('nama_barang')->after('gambar');
            $table->decimal('harga', 8, 2)->after('nama_barang');
        });
    }

    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn(['gambar', 'nama_barang', 'harga']);
        });
    }
};

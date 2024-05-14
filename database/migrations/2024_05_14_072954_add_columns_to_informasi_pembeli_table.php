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
        Schema::table('informasi_pembeli', function (Blueprint $table) {
            $table->unsignedBigInteger('produk_id');
            $table->unsignedBigInteger('member_id');
            $table->decimal('total_harga', 15, 2)->nullable();
            $table->unsignedBigInteger('cart_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('informasi_pembeli', function (Blueprint $table) {
            $table->dropColumn('produk_id');
            $table->dropColumn('member_id');
            $table->dropColumn('total_harga');
            $table->dropColumn('cart_id');
        });
    }
};

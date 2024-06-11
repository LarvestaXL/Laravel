<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToCheckoutTable extends Migration
{
    public function up()
    {
        Schema::table('checkout', function (Blueprint $table) {
            $table->string('status')->default('Diterima'); // Default status is 'Diterima'
        });
    }

    public function down()
    {
        Schema::table('checkout', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}


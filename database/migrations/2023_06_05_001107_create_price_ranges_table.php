<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePriceRangesTable extends Migration
{
    public function up()
    {
        Schema::create('price_ranges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        DB::table('price_ranges')->insert([
            ['name' => '0.5-1.0 OMR/Sq.m'],
            ['name' => '1.1-1.5 OMR/Sq.m'],
            ['name' => '1.6-2.0 OMR/Sq.m'],
            ['name' => '2.1-2.5 OMR/Sq.m'],
            ['name' => 'more than 2.5 OMR/Sq.m'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('price_ranges');
    }
}
?>

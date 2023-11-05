<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('governorates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('governorates')->insert([
            ['name' => 'Ad Dakhiliyah'],
            ['name' => 'Ad Dhahirah'],
            ['name' => 'Al Batinah North'],
            ['name' => 'Al Batinah South'],
            ['name' => 'Al Buraimi'],
            ['name' => 'Al Wusta'],
            ['name' => 'Ash Sharqiyah North'],
            ['name' => 'Ash Sharqiyah South'],
            ['name' => 'Dhofar'],
            ['name' => 'Muscat'],
            ['name' => 'Musandam'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('governorates');
    }
};

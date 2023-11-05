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
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('governorate_id')->constrained();
            $table->timestamps();
        });

        DB::table('provinces')->insert([
            // Ad Dakhiliyah Governorate
            ['name' => 'Nizwa', 'governorate_id' => 1],
            ['name' => 'Samail', 'governorate_id' => 1],
            ['name' => 'Bahla', 'governorate_id' => 1],
            ['name' => 'Adam', 'governorate_id' => 1],
            ['name' => 'Al Hamra', 'governorate_id' => 1],
            ['name' => 'Manah', 'governorate_id' => 1],
            ['name' => 'Izki', 'governorate_id' => 1],
            ['name' => 'Bidbid', 'governorate_id' => 1],

            // Al Dhahirah Governorate
            ['name' => 'Ibri', 'governorate_id' => 2],
            ['name' => 'Yanqul', 'governorate_id' => 2],
            ['name' => 'Dhank', 'governorate_id' => 2],

            // Al Batinah North Governorate
            ['name' => 'Sohar', 'governorate_id' => 3],
            ['name' => 'Shinas', 'governorate_id' => 3],
            ['name' => 'Liwa', 'governorate_id' => 3],
            ['name' => 'Saham', 'governorate_id' => 3],
            ['name' => 'Al Khaburah', 'governorate_id' => 3],
            ['name' => 'Suwayq', 'governorate_id' => 3],

            // Al Batinah South Governorate
            ['name' => 'Nakhal', 'governorate_id' => 4],
            ['name' => 'Wadi Al Maawil', 'governorate_id' => 4],
            ['name' => 'Al Awabi', 'governorate_id' => 4],
            ['name' => 'Al Musanaah', 'governorate_id' => 4],
            ['name' => 'Barka', 'governorate_id' => 4],
            ['name' => 'Rustaq', 'governorate_id' => 4],

            // Al Buraimi Governorate
            ['name' => 'Al Buraimi', 'governorate_id' => 5],
            ['name' => 'Mahdah', 'governorate_id' => 5],
            ['name' => 'As Sunaynah', 'governorate_id' => 5],

            // Al Wusta Governorate
            ['name' => 'Haima', 'governorate_id' => 6],
            ['name' => 'Duqm', 'governorate_id' => 6],
            ['name' => 'Mahout', 'governorate_id' => 6],
            ['name' => 'Al Jazer', 'governorate_id' => 6],

            // Ash Sharqiyah North Governorate
            ['name' => 'Ibra', 'governorate_id' => 7],
            ['name' => 'Al-Mudhaibi', 'governorate_id' => 7],
            ['name' => 'Bidiya', 'governorate_id' => 7],
            ['name' => 'Wadi Bani Khaled', 'governorate_id' => 7],
            ['name' => 'Dema Wa Thaieen', 'governorate_id' => 7],
            ['name' => 'Al Qabil', 'governorate_id' => 7],

            // Ash Sharqiyah South Governorate
            ['name' => 'Masirah', 'governorate_id' => 8],
            ['name' => 'Sur', 'governorate_id' => 8],
            ['name' => 'Jalan Bani Bu Hassan', 'governorate_id' => 8],
            ['name' => 'Jalan Bani Bu Ali', 'governorate_id' => 8],
            ['name' => 'Al Kamil Wal Wafi', 'governorate_id' => 8],
            ['name' => 'Al Munassir', 'governorate_id' => 8],

            // Dhofar Governorate
            ['name' => 'Salalah', 'governorate_id' => 9],
            ['name' => 'Taqa', 'governorate_id' => 9],
            ['name' => 'Mirbat', 'governorate_id' => 9],
            ['name' => 'Sadah', 'governorate_id' => 9],
            ['name' => 'Thumrait', 'governorate_id' => 9],
            ['name' => 'Rakhyut', 'governorate_id' => 9],
            ['name' => 'Shaleem and Al-Halaniyat Islands', 'governorate_id' => 9],


            ['name' => 'Muscat', 'governorate_id' => 10],
            ['name' => 'Muttrah', 'governorate_id' => 10],
            ['name' => 'Bawshar', 'governorate_id' => 10],
            ['name' => 'Seeb', 'governorate_id' => 10],
            ['name' => 'Al Amarat', 'governorate_id' => 10],
            ['name' => 'Qurayyat', 'governorate_id' => 10],


            ['name' => 'Khasab', 'governorate_id' => 11],
            ['name' => 'Bukha', 'governorate_id' => 11],
            ['name' => 'Daba AL Bayah', 'governorate_id' => 11],
            ['name' => 'Sadah', 'governorate_id' => 11],
            ['name' => 'Madha', 'governorate_id' => 11]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provinces');
    }
};

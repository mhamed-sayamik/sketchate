<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('krooky_file');
            $table->string('milkyah_file');
            $table->string('owner_id_file');
            $table->boolean('support_omanian_firms');
            $table->string('status')->default("ongoing");
            $table->foreignId('price_range_id')->constrained();
            $table->unsignedBigInteger('winner_company')->nullable();
            $table->foreign('winner_company')->references('id')->on('companies');
            $table->date('deadline');
            $table->foreignId("user_id")->constrained();
            $table->integer("aprox-area")->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
}

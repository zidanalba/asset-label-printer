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
        Schema::create('assets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('code')->unique();
            $table->uuid('category_id')->nullable();
            $table->uuid('organization_id');
            $table->uuid('infrastructure_id')->nullable(); // default location
            $table->foreign('category_id')->references('id')->on('asset_categories');
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('infrastructure_id')->references('id')->on('infrastructures');
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
        Schema::dropIfExists('assets');
    }
};

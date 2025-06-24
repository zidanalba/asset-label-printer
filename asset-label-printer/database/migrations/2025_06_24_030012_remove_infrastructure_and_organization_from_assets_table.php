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
        Schema::table('assets', function (Blueprint $table) {
            // Drop foreign key constraints first
            $table->dropForeign(['organization_id']);
            $table->dropForeign(['infrastructure_id']);
            
            // Drop the columns
            $table->dropColumn(['organization_id', 'infrastructure_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {
            // Add the columns back
            $table->uuid('organization_id')->after('category_id');
            $table->uuid('infrastructure_id')->nullable()->after('organization_id');
            
            // Add foreign key constraints back
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('infrastructure_id')->references('id')->on('infrastructures');
        });
    }
};

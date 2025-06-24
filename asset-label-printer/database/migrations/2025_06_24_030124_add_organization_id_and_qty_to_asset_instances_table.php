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
        Schema::table('asset_instances', function (Blueprint $table) {
            // Add organization_id column
            $table->uuid('organization_id')->after('asset_id');
            
            // Add qty column
            $table->integer('qty')->default(1)->after('organization_id');
            
            // Add foreign key constraint for organization_id
            $table->foreign('organization_id')->references('id')->on('organizations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset_instances', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['organization_id']);
            
            // Drop the columns
            $table->dropColumn(['organization_id', 'qty']);
        });
    }
};

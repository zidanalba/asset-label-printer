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
            //
            $table->uuid('organization_id')->nullable()->change();
            $table->uuid('infrastructure_id')->nullable()->change();
            $table->dropColumn('qty');
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
            //
            $table->uuid('organization_id')->nullable(false)->change();
            $table->uuid('infrastructure_id')->nullable(false)->change();
            $table ->integer('qty');
        });
    }
};

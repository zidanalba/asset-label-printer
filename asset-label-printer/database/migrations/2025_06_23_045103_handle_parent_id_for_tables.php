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
        //
        Schema::table('asset_categories', function (Blueprint $table) {
            $table->foreign('parent_id')
                ->references('id')
                ->on('asset_categories')
                ->nullOnDelete(); // or ->onDelete('set null');
        });
        Schema::table('infrastructures', function (Blueprint $table) {
            $table->foreign('parent_id')
                ->references('id')
                ->on('infrastructures')
                ->nullOnDelete(); // or ->onDelete('set null');
        });
        Schema::table('organizations', function (Blueprint $table) {
            $table->foreign('parent_id')
                ->references('id')
                ->on('organizations')
                ->nullOnDelete(); // or ->onDelete('set null');
        });
        Schema::table('positions', function (Blueprint $table) {
            $table->foreign('parent_id')
                ->references('id')
                ->on('positions')
                ->nullOnDelete(); // or ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('asset_categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });
        Schema::table('infrastructures', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });
        Schema::table('positions', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });
    }
};

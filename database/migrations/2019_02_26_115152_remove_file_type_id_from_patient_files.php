<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFileTypeIdFromPatientFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('file_receptions', function (Blueprint $table) {
            $table->dropForeign(['file_type_id']);
            $table->dropColumn('file_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('file_receptions', function (Blueprint $table) {
            $table->unsignedInteger('file_type_id');

            $table->foreign('file_type_id')->references('id')->on('file_types')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }
}

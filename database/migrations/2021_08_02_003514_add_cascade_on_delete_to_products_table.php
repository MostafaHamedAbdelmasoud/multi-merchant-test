<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCascadeOnDeleteToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('products', 'tag_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign(['tag_id']);
                $table->dropColumn('tag_id');
            });
        }
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('tag_id')->constrained('tags')->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
}

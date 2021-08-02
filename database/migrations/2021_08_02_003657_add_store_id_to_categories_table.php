<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStoreIdToCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('categories', 'store_id')) {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropForeign(['store_id']);
                $table->dropColumn('store_id');
            });
        }
        Schema::table('categories', function (Blueprint $table) {
            //
            $table->foreignId('store_id')->after('id')->constrained('stores')->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            //
        });
    }
}

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
        Schema::table('invoice_product_lines', static function (Blueprint $table): void {
            $table->string('name');
            $table->integer('price');
            $table->string('currency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_product_lines', static function (Blueprint $table): void {
            $table->dropColumn('name');
            $table->dropColumn('price');
            $table->dropColumn('currency');
        });
    }
};

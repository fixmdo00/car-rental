<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->date('return_date')->nullable()->after('end_date');
            $table->integer('total_days')->nullable()->after('return_date');
            $table->decimal('total_cost', 10, 2)->nullable()->after('total_days');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn(['return_date', 'total_days', 'total_cost']);
        });
    }
};

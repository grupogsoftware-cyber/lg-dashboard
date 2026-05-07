<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionRecordsTable extends Migration
{
    public function up()
    {
        Schema::create('production_records', function (Blueprint $table) {
            $table->id();
            $table->string('product_line');
            $table->date('production_date');
            $table->unsignedInteger('quantity_produced');
            $table->unsignedInteger('quantity_defects');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('production_records');
    }
}

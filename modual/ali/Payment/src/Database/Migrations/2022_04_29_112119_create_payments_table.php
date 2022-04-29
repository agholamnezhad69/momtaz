<?php

use ali\Payment\Models\Payment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{

    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id');
            $table->foreignId('paymentable_id');
            $table->string('paymentable_type');
            $table->string('amount', 10);
            $table->string('invoice_id');
            $table->string('gateway');
            $table->enum('status', Payment::$statuses);
            $table->tinyInteger('seller_percent')->unsigned();
            $table->string('seller_share', 10);
            $table->string('site_share', 10);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}

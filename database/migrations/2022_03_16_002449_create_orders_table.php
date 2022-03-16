<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')
                ->constrained('partners')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->dateTime('datetime');
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('extra', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->string('status', 50)->default('Pendente');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

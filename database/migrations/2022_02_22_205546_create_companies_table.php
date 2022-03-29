<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('name', 100);
            $table->string('corporate_name', 100)->unique();
            $table->string('cnpj', 14)->unique();
            $table->string('image_url', 200)->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
        Schema::create('company_adresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('cep', 8);
            $table->string('street', 200);
            $table->string('number', 20)->nullable();
            $table->string('neighborhood', 200);
            $table->string('city', 200);
            $table->string('state', 2);
            $table->text('notes')
                ->nullable();
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
        Schema::dropIfExists('company_adresses');
        Schema::dropIfExists('companies');
    }
}

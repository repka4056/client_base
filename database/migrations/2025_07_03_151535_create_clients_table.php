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
    Schema::create('clients', function (Blueprint $table) {
    $table->id();
    $table->string('nume');
    $table->string('prenume');
    $table->string('adresa');
    $table->string('regiune');
    $table->string('numar_casa');
    $table->decimal('latitudine', 10, 7)->nullable();
    $table->decimal('longitudine', 10, 7)->nullable();
    $table->timestamps();
});

}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};

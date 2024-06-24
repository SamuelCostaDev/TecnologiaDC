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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nomeProduto');
            $table->string('referenciaProduto')->nullable();
            $table->string('tipoProduto');
            $table->decimal('valorCompra', 8, 2);
            $table->decimal('valorVenda', 8, 2);
            $table->integer('estoqueMinimo');
            $table->string('codigoBarra')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

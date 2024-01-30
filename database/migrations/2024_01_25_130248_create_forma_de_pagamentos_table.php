<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('forma_de_pagamentos', function (Blueprint $table) {
            $table->id();
            $table->string('tipos_de_pagamento')->unique()->nullable(false); 
            $table->string('status_do_pagamento')->nullable(false); 
            $table->decimal('taxa')->nullable(true); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forma_de_pagamentos');
    }
};

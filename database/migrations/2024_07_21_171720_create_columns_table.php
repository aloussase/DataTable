<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('columns', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("nombre", 255);
            $table->string("tipo_dato", 255);
            $table->boolean("es_pk")->nullable()->default(false);
            $table->boolean("es_fk")->nullable()->default(false);
            $table->boolean("es_null")->nullable()->default(false);
            $table->string("valor_defecto", 255)->nullable()->default("-");
            $table->string("descripcion", 255);
            $table->foreignId("table_id")
                ->constrained()
                ->onDelete("cascade")
                ->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('columns');
    }
};

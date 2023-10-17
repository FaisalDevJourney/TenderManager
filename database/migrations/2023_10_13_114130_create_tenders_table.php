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
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->string("Name");
            $table->string("Number")->nullable();
            $table->text("ScopeofWork")->nullable();
            $table->enum("status",["Tendering Stage","Closed", "Awarded"])->default("Tendering Stage");
            $table->string("client");
            $table->integer("value")->nullable();
            $table->string("contractor");
            $table->string("Consultant")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenders');
    }
};

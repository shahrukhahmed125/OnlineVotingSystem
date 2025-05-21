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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('constituency_id')->constrained('assemblies')->onDelete('cascade');
            $table->foreignId('political_party_id')->constrained('political_parties')->onDelete('cascade');
            $table->string('name');
            $table->string('CNIC')->unique();
            $table->string('email')->unique();
            $table->integer('phone');
            $table->string('city');
            $table->string('address')->nullable();
            $table->timestamps();
            // $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};

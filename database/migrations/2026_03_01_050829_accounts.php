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
    Schema::create('accounts', function (Blueprint $table) {
    $table->id();
    $table->string('user')->unique();
    $table->string('full_name');
    $table->string('password'); 
    $table->enum('role', ['admin', 'registrar'])->default('registrar');
   
    $table->timestamps();
});
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      //
    }
};

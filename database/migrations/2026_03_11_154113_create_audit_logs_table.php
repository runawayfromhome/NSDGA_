<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
   public function up()
{
    Schema::create('audit_logs', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // Who did the action
        $table->string('action');              // What they did
        $table->string('target');              // Who they did it to
        $table->string('ip_address');
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};

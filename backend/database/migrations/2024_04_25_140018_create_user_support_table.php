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
        Schema::create('supports_user', function (Blueprint $table) {
            $table->id();
            $table -> unsignedBiginteger ( 'user_id' );
            $table -> unsignedBiginteger ( 'supports_id' );
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('support_id')->references('id')->on('supports')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supports_user');
    }
};

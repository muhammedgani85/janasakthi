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
        Schema::create('menu_permissions', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('role_id');
          $table->unsignedBigInteger('menu_id')->nullable();
          $table->unsignedBigInteger('submenu_id')->nullable();
          $table->timestamps();


         /*  $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
          $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
          $table->foreign('submenu_id')->references('id')->on('sub_menus')->onDelete('cascade'); */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_permissions');
    }
};

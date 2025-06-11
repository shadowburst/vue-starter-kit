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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('team_id')->nullable()->after('owner_id')->constrained('teams')->nullOnDelete();
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->foreign('team_id')->references('id')->on('teams')->cascadeOnDelete();
        });
        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->foreign('team_id')->references('id')->on('teams')->cascadeOnDelete();
        });
        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->foreign('team_id')->references('id')->on('teams')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
        });
        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('team_id');
        });
        Schema::dropIfExists('teams');
    }
};

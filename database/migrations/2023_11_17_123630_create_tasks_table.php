<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->foreignUuid('parent_id')->nullable();
            $table->foreignUuid('user_id')->index();
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedTinyInteger('priority');
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('completed_at')->nullable();

            $table->fullText(['title', 'description']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('genre')->nullable();
            $table->enum('status', ['watching','completed','plan_to_watch','dropped'])->default('plan_to_watch');
            $table->unsignedInteger('total_episodes')->nullable();
            $table->unsignedInteger('episodes_watched')->default(0);
            $table->decimal('rating', 3, 1)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('animes');
    }
};

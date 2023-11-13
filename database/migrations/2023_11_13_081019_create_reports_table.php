<?php

use Carbon\Carbon;
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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->dateTime('reported_at')->default(Carbon::now());
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('category')->nullable();
            $table->text('attached_file')->nullable();
            $table->dateTime('resolution_time')->default(Carbon::now());
            $table->text('note_by_admin')->nullable();
            $table->char('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};

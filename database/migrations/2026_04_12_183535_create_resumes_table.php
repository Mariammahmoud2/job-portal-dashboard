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
        Schema::create('resumes', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string('file_url');
            $table->string('file_name');
            $table->longtext('content')->nullable();
            $table->longtext('education')->nullable();
            $table->longtext('summary')->nullable();
            $table->longtext('skills')->nullable();
            $table->longtext('experience')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};

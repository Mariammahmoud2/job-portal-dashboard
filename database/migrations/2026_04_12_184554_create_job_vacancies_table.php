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
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->string('salary');
            $table->enum('type', ['Full-time', 'Part-time', 'Remote', 'Hybrid'])->default('Full-time');   
            $table->softDeletes();
            $table->timestamps();
             $table->uuid('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('restrict');
             $table->uuid('category_id');
            $table->foreign('category_id')->references('id')->on('job_categories')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};

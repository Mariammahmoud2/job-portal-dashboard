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
    Schema::table('job_applications', function (Blueprint $table) {
        // إضافة الأعمدة الجديدة
        $table->float('ai_generated_score', 2)->default(0);
        $table->longtext('ai_generated_feedback')->nullable();
    });
}

public function down(): void
{
    Schema::table('job_applications', function (Blueprint $table) {
        $table->dropColumn(['ai_generated_score', 'ai_generated_feedback']);
    });
}
};

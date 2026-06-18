<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->unsignedInteger('min_students')->default(1)->after('price');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->json('students_data')->nullable()->after('email');
            $table->unsignedInteger('student_count')->default(1)->after('students_data');
        });
    }

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('min_students');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('students_data');
            $table->dropColumn('student_count');
        });
    }
};

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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('careers_id');
            $table->string('name');
            $table->string('email');
            $table->string('phone_number', 25);
            $table->text('message')->nullable();
            $table->text('extra_data')->nullable();
            $table->string('resume');
            $table->string('ip_address');
            $table->text('user_agent');
            $table->string('referrer_link')->nullable();
            $table->text('remarks')->nullable();
            $table->string('status', 50)->default('Open');
            $table->bigInteger('updated_by')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->useCurrent();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};

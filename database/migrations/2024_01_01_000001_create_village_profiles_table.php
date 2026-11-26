<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('village_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('village_name');
            $table->string('district')->nullable();
            $table->string('regency')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->text('history')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
            $table->text('geography')->nullable();
            $table->string('village_head_name')->nullable();
            $table->string('village_head_photo')->nullable();
            $table->text('village_head_message')->nullable();
            $table->unsignedInteger('total_population')->default(0);
            $table->unsignedInteger('total_families')->default(0);
            $table->decimal('total_area', 10, 2)->default(0);
            $table->unsignedInteger('total_dusun')->default(0);
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('website')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('village_profiles');
    }
};

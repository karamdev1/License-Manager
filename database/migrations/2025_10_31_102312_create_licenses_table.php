<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apps', function (Blueprint $table) {
            $table->id();
            $table->uuid('edit_id')->unique();
            $table->uuid('app_id')->unique();
            $table->string('name')->unique();
            $table->integer('price');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->string('registrar')->nullable();
            $table->timestamps();
        });

        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->uuid('edit_id');
            $table->string('app_id');
            $table->string('owner');
            $table->string('license')->unique();
            $table->biginteger('max_devices')->default(1);
            $table->mediumtext('devices')->nullable();
            $table->biginteger('duration')->default(30);
            $table->dateTime('expire_date')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->string('registrar')->nullable();
            $table->timestamps();
        });

        Schema::create('licenses_history', function(Blueprint $table) {
            $table->id();
            $table->string('license_id');
            $table->string('user');
            $table->enum('type', ['Create', 'Update'])->default('Create');
            $table->timestamps();
        });

        Schema::create('app_history', function(Blueprint $table) {
            $table->id();
            $table->string('app_id');
            $table->string('user');
            $table->enum('type', ['Create', 'Update'])->default('Create');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_history');
        Schema::dropIfExists('apps');
        Schema::dropIfExists('licenses_history');
        Schema::dropIfExists('licenses');
    }
};

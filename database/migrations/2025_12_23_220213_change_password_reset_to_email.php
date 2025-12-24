<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->string('email')->primary();
        });
    }

    public function down()
    {
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            $table->string('username')->primary();
            $table->dropColumm('email');
        });
    }
};

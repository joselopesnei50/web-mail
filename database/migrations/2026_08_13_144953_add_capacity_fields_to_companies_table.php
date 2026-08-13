<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->integer('max_users')->nullable()->default(5);
            $table->integer('max_emails_month')->nullable()->default(1000);
            $table->integer('storage_limit_mb')->nullable()->default(1024);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['max_users', 'max_emails_month', 'storage_limit_mb']);
        });
    }
};

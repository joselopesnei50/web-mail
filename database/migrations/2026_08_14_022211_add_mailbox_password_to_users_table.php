<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('mailbox_password_encrypted')->nullable()->after('password');
            $table->boolean('has_mailbox')->default(false)->after('mailbox_password_encrypted');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['mailbox_password_encrypted', 'has_mailbox']);
        });
    }
};

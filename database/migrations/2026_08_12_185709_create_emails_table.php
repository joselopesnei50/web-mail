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
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Dono do email (quem enviou ou quem recebeu)
            $table->string('sender'); // Email de quem enviou
            $table->string('recipient'); // Email de quem recebeu
            $table->string('subject')->nullable(); // Assunto
            $table->text('body')->nullable(); // Corpo do e-mail
            $table->boolean('is_read')->default(false); // Lido ou não (para inbox)
            $table->enum('type', ['inbox', 'sent', 'draft'])->default('inbox'); // Tipo do e-mail
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emails');
    }
};

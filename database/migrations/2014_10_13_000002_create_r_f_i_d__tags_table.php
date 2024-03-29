<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rfid_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->string('tag_uid')->unique();
            $table->string('role');
            $table->boolean('tag_active')->default(true);
            $table->timestamps();

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::dropIfExists('rfid_tags');
}
};

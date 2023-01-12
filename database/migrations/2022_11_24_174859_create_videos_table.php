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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('slug');
            $table->text('description');
            $table->text('video_type');
            $table->text('url')->nullable();
            $table->text('cover');
            $table->string('length');
            $table->decimal('charges', 17, 2, true)->default('0.00');
            $table->decimal('earnable', 11, 2, true)->default('0.00');
            $table->decimal('earnable_ns', 11, 2, true)->default('0.0');
            $table->string('earned_after');
            $table->enum('status', ['0', '1'])->default('1');
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
        Schema::dropIfExists('videos');
    }
};

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
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_user_id')->constrained('users')->comment("Owner of referral link");
            $table->foreignId('referred_user_id')->constrained('users')->comment("User of referral link");
            $table->string('referral_type')->comment("signup, video");
            $table->json('meta')->nullable();
            $table->decimal('amount', 11, 5)->default('0.00000');
            $table->enum('status', ['0', '1', '2'])->default(0)->comment("0=n/a, 1=bonus in, 2=bonus out email");
            $table->timestamp('bonus_at')->nullable()->default(null)->comment("Time of bonus entry");
            $table->timestamp('credited_at')->nullable()->default(null)->comment("Time of bonus exist to referrer wallet");
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
        Schema::dropIfExists('referrals');
    }
};

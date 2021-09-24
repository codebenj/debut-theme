<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserExtendTrialRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_extend_trial_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('extend_trials_id')->nullable();
            $table->string('extend_trial_proof_image')->nullable();
            $table->string('extend_trial_status')->nullable();
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
        Schema::dropIfExists('user_extend_trial_requests');
    }
}

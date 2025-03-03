<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('leave_type', function (Blueprint $table) { // Leave will exist for every staff (parmenant) , one time setup
            $table->id();
            $table->string('name'); // Annual Leave, Medical Leave, etc
            $table->integer('carry_forward')->default(0); // 0 = false, 1 = true (can carry forward)
            $table->float('carry_forward_percentage')->default(0); // 0 means no percentage
            $table->float('carry_forward_max_days')->default(0); // 0 means no limit
            $table->timestamps();
        });

        Schema::create('leave_config', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // FULL DAY, HALF DAY, TIME OFF (2 HOURS MAX), etc
            $table->unsignedBigInteger('leave_type_id'); // Leave type id group (will count in leave type group)
            $table->double('rate')->default(1); // 1 for full day, 0.5 for half day, etc // need to store in leave record
            $table->integer('notice_period')->default(0); // notice period in days // only used when selecting leave
            $table->integer('max_continuous_days')->default(0);// only used when selecting leave
            $table->integer('attachment_required')->default(0); // 0 = false, 1 = true
            $table->integer('active')->default(1); // selectable or not (cannot delete but can deactivate)
            $table->timestamps();
        });

        Schema::create('leave_user_balance', function (Blueprint $table) {
            $table->id();
            $table->integer('year'); 
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('leave_type_id');
            $table->float('annual_limit')->default(0); // 0 means no limit
            $table->float('taken')->default(0); // taken leaves , balance = annual_limit - taken ('taken' will be counted from approved leaves records history) // will be used as counter
            $table->float('carry_forward_leaves')->default(0); // carry forward leaves from previous year (added manually but based on leave type rules settings)
            $table->timestamps();
        });

        Schema::create('leave_record', function (Blueprint $table) {
            $table->id();
            // staff fillid in leave record
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('leave_type_id');
            $table->unsignedBigInteger('leave_config_id');
            $table->float('rate')->default(1); // 1 for full day, 0.5 for half day, etc
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('duration')->default(1); // in days
            $table->string('remarks')->nullable();
            $table->string('attachment')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected

            // admin filled in leave record
            $table->string('approved_by')->nullable();
            $table->date('approved_date')->nullable();
            $table->string('admin_remarks')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_type');
        Schema::dropIfExists('leave_config');
        Schema::dropIfExists('leave_user_balance');
        Schema::dropIfExists('leave_record');
    }
};

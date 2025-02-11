<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('nric')->unique();
            $table->date('starting_date');
            $table->enum('work_type', ['full_time', 'part_time', 'contract', 'intern', 'terminated']);
            $table->text('reason')->nullable();
            $table->text('additional_details')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('email_personal')->nullable();
            $table->string('email_company')->nullable();
            $table->string('phone_number')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('intern_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
            $table->string('university');
            $table->date('date_start');
            $table->date('date_end');
            $table->foreignId('supervisor_id')->nullable()->constrained('staff');
            $table->string('university_supervisor');
            $table->string('university_supervisor_contact');
            $table->text('other_details')->nullable();
            $table->timestamps();
        });

        Schema::create('work_type_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
            $table->enum('work_type', ['full_time', 'part_time', 'contract', 'intern', 'terminated']);
            $table->text('reason')->nullable();
            $table->foreignId('updated_by')->constrained('users'); // User who made the change
            $table->dateTime('start_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_type_logs');
        Schema::dropIfExists('intern_details');
        Schema::dropIfExists('staff');
    }
};

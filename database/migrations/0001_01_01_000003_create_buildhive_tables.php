<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Freelancer profiles
        Schema::create('freelancer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('bio')->nullable();
            $table->json('skills')->nullable();
            $table->enum('experience_level', ['junior', 'mid', 'senior', 'expert'])->default('mid');
            $table->string('portfolio_url')->nullable();
            $table->decimal('hourly_rate', 8, 2)->nullable();
            $table->timestamps();
        });

        // Projects
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->decimal('budget', 10, 2);
            $table->enum('status', ['open', 'in_progress', 'review', 'completed', 'cancelled'])->default('open');
            $table->date('deadline')->nullable();
            $table->json('skills_required')->nullable();
            $table->timestamps();
        });

        // Proposals
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('freelancer_id')->constrained('users')->cascadeOnDelete();
            $table->text('cover_letter');
            $table->decimal('bid_amount', 10, 2);
            $table->integer('duration_days');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();
        });

        // Teams
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
        });

        // Team members
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('role_in_team')->default('developer');
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });

        // Tasks
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['todo', 'in_progress', 'done'])->default('todo');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->date('due_date')->nullable();
            $table->timestamps();
        });

        // Reviews
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reviewer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('reviewee_id')->constrained('users')->cascadeOnDelete();
            $table->tinyInteger('rating')->unsigned();
            $table->text('comment')->nullable();
            $table->timestamps();
        });

        // Notifications
        Schema::create('notifications_custom', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->text('message');
            $table->string('url')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications_custom');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('team_members');
        Schema::dropIfExists('teams');
        Schema::dropIfExists('proposals');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('freelancer_profiles');
    }
};

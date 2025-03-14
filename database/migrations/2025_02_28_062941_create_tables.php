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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50);
            $table->string('email', 50)->unique();
            $table->string('password', 255);
            $table->string('first_name', 50);
            $table->string('middle_name', 50)->nullable();
            $table->string('last_name', 50);
            $table->string('profile_photo')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('status', ['active', 'inactive', 'blocked'])->default('active');
            $table->enum('user_role_type', ['user', 'admin']);
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('users_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->double('balance')->default(0);
            $table->string('deposit_method')->nullable();
            $table->string('withdraw_method')->nullable();
            $table->timestamps();
        });

        Schema::create('user_wallet_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_wallet_id')->constrained('users_wallets')->onDelete('cascade');
            $table->double('amount')->default(0);
            $table->enum('transfer_type', ['withdraw', 'deposit', 'system_transfer']);
            $table->json('metadata')->nullable();
            $table->timestamp('withdraw_at')->nullable();
            $table->timestamp('deposit_at')->nullable();
            $table->timestamps();
        });

        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('service_categories')->onDelete('cascade');
            $table->string('title', 150);
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive']);
            $table->timestamps();
        });

        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->double('hourly_rate')->nullable()->default(0);
            $table->integer('country_code');
            $table->string('contact_number', 20);
            $table->enum('gender', ['Male', 'Female']);
            $table->string('personal_description', 255)->nullable();
            $table->integer('age')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('address', 120);
            $table->string('latitude', 100);
            $table->string('longitude', 100);
            $table->string('identification_file', 250)->nullable();
            $table->string('nbi_copy_file', 250)->nullable();
            $table->boolean('is_verified_worker')->default(0);
            $table->timestamps();
        });

        Schema::create('worker_personal_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id')->constrained('workers')->onDelete('cascade');
            $table->string('document_filename', 250);
            $table->enum('status', ['pending', 'rejected', 'approved'])->default('pending');
            $table->timestamps();
        });

        Schema::create('worker_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id')->constrained('workers')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('country_code');
            $table->string('contact_number', 20);
            $table->string('address', 100);
            $table->string('latitude', 100);
            $table->string('longitude', 100);
            $table->string('facebook_url', 100)->nullable();
            $table->timestamps();
        });

        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->string('title', 150);
            $table->string('description', 150);
            $table->text('notes')->nullable();
            $table->enum('transaction_type', ['fixed', 'hourly'])->default('fixed');
            $table->string('job_duration', 100)->nullable();
            $table->string('address', 250);
            $table->string('latitude', 100);
            $table->string('longitude', 100);
            $table->enum('urgency', ['book_now', 'scheduled']);
            $table->date('scheduled_date');
            $table->time('scheduled_time');
            $table->enum('status', ['pending', 'published', 'blocked', 'contracted', 'completed', 'cancelled'])->default('pending');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('job_post_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_post_id')->constrained('job_posts')->cascadeOnDelete();
            $table->string('attachment_file');
            $table->timestamps();
        });

        Schema::create('job_ranked_workers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_post_id')->constrained('job_posts')->cascadeOnDelete();
            $table->foreignId('worker_id')->constrained('workers')->cascadeOnDelete();
            $table->double('total_score')->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('job_proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id')->constrained('workers')->onDelete('cascade');
            $table->foreignId('job_post_id')->constrained('job_posts')->onDelete('cascade');
            $table->double('offer_amount')->default(0);
            $table->string('details', 250)->nullable();
            $table->string('address', 150);
            $table->string('latitude', 100);
            $table->string('longitude', 100);
            $table->enum('status', ['draft', 'submitted', 'approved', 'cancelled'])->default('draft');
            $table->timestamps();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number', 50);
            $table->double('processing_fee')->default(0);
            $table->double('sub_amount')->default(0);
            $table->double('discount')->default(0);
            $table->double('total_amount')->default(0);
            $table->string('payment_method', 100);
            $table->enum('status', ['paid', 'unpaid'])->default('unpaid');
            $table->timestamps();
        });

        Schema::create('job_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('contract_code_number', 50);
            $table->foreignId('transaction_id')->nullable()->constrained('transactions')->nullOnDelete();
            $table->foreignId('proposal_id')->constrained('job_proposals')->onDelete('cascade');
            $table->foreignId('job_post_id')->constrained('job_posts')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('worker_id')->constrained('workers')->onDelete('cascade');
            $table->double('contract_amount')->default(0);
            $table->double('client_service_fee')->default(0);
            $table->double('worker_service_fee')->default(0);
            $table->double('contract_total_amount')->default(0);
            $table->json('metadata')->nullable();
            $table->boolean('is_client_approved')->default(0);
            $table->boolean('is_worker_approved')->default(0);
            $table->enum('status', ['in_progress', 'cancelled', 'reported', 'success', 'failed']);
            $table->text('failed_reason')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->enum('worker_progress', ['waiting', 'preparing', 'on_way', 'arriving', 'arrived', 'working', 'done', 'cancelled']);
            $table->timestamps();
        });

        Schema::create('contract_worker_progress_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('job_contracts')->onDelete('cascade');
            $table->foreignId('worker_id')->constrained('workers')->onDelete('cascade');
            $table->enum('status', ['preparing', 'on_way', 'arriving', 'arrived', 'working', 'done', 'cancelled']);
            $table->string('comment')->nullable();
            $table->timestamp('arrived_at')->nullable();
            $table->timestamp('started_working_at')->nullable();
            $table->timestamp('finished_working_at')->nullable();
            $table->timestamps();
        });

        Schema::create('app_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('feedback_message')->nullable();
            $table->integer('rate');
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('worker_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reviewer_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('worker_id')->constrained('workers')->onDelete('cascade');
            $table->text('feedback_message');
            $table->integer('rate');
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('client_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reviewer_id')->constrained('workers')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->text('feedback_message');
            $table->integer('rate');
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('job_contract_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('job_contracts')->cascadeOnDelete();
            $table->double('amount')->default(0);
            $table->double('withdraw_amount')->default(0);
            $table->timestamp('contract_withdraw_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('job_posts');
        Schema::dropIfExists('clients');
        Schema::dropIfExists('worker_services');
        Schema::dropIfExists('worker_personal_documents');
        Schema::dropIfExists('workers');
        Schema::dropIfExists('services');
        Schema::dropIfExists('service_categories');
        Schema::dropIfExists('client_reviews');
        Schema::dropIfExists('worker_reviews');
        Schema::dropIfExists('app_reviews');
        Schema::dropIfExists('job_contracts');
        Schema::dropIfExists('job_proposals');
    }
};

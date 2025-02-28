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
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('status', ['active', 'inactive', 'blocked'])->default('active');
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

        Schema::create('wallet_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->double('amount')->default(0);
            $table->enum('transfer_type', ['withdraw', 'deposit']);
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
            $table->timestamps();
        });

        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->double('hourly_rate')->default(0);
            $table->integer('country_code');
            $table->string('contact_number', 20);
            $table->enum('gender', ['Male', 'Female']);
            $table->string('personal_description', 255)->nullable();
            $table->integer('age')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('address', 120);
            $table->string('latitute', 100);
            $table->string('longitude', 100);
            $table->string('identification_filename', 250);
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
            $table->string('latitute', 100);
            $table->string('longitude', 100);
            $table->string('facebook_url', 100)->nullable();
            $table->timestamps();
        });

        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained('clients')->onDelete('cascade');
            $table->string('title', 150);
            $table->string('description', 150);
            $table->text('notes')->nullable();
            $table->enum('transaction_type', ['fixed', 'hourly'])->default('fixed');
            $table->double('price_amount')->default(0);
            $table->string('job_duration', 100)->nullable();
            $table->string('address', 250);
            $table->string('latitute', 100);
            $table->string('longitude', 100);
            $table->enum('urgency', ['book_now', 'scheduled']);
            $table->date('scheduled_date');
            $table->time('scheduled_time');
            $table->enum('status', ['pending', 'published', 'blocked'])->default('pending');
            $table->timestamp('published_at')->nullable();
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
    }
};

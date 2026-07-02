<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'email_verified_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            });
        }

        if (! Schema::hasColumn('users', 'otp_code_hash')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('otp_code_hash')->nullable()->after('password');
            });
        }

        if (! Schema::hasColumn('users', 'otp_expires_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('otp_expires_at')->nullable()->after('otp_code_hash');
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'otp_expires_at')) {
                $table->dropColumn('otp_expires_at');
            }

            if (Schema::hasColumn('users', 'otp_code_hash')) {
                $table->dropColumn('otp_code_hash');
            }

            if (Schema::hasColumn('users', 'email_verified_at')) {
                $table->dropColumn('email_verified_at');
            }
        });
    }
};
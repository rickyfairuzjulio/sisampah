<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add verification and contact fields to bank_sampahs
        Schema::table('bank_sampahs', function (Blueprint $table) {
            if (!Schema::hasColumn('bank_sampahs', 'status_verifikasi')) {
                $table->string('status_verifikasi', 50)->default('draft')->after('status');
            }
            if (!Schema::hasColumn('bank_sampahs', 'nomor_registrasi')) {
                $table->string('nomor_registrasi')->nullable()->after('kode_bank');
            }
            if (!Schema::hasColumn('bank_sampahs', 'penanggung_jawab')) {
                $table->string('penanggung_jawab')->nullable()->after('nama');
            }
            if (!Schema::hasColumn('bank_sampahs', 'telepon_pj')) {
                $table->string('telepon_pj')->nullable()->after('penanggung_jawab');
            }
            if (!Schema::hasColumn('bank_sampahs', 'email_pj')) {
                $table->string('email_pj')->nullable()->after('telepon_pj');
            }
        });

        // 2. Bank Sampah Documents table
        if (!Schema::hasTable('bank_sampah_documents')) {
            Schema::create('bank_sampah_documents', function (Blueprint $table) {
                $table->id();
                $table->foreignId('bank_sampah_id')->constrained('bank_sampahs')->onDelete('cascade');
                $table->string('jenis_dokumen'); // ktp, legalitas, domisili, foto_lokasi, rekening, dokumen_tambahan
                $table->string('file_path');
                $table->string('nomor_dokumen')->nullable();
                $table->enum('status_review', ['pending', 'approved', 'revision_requested', 'rejected'])->default('pending');
                $table->text('catatan')->nullable();
                $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamps();
            });
        }

        // 3. Bank Sampah Verifications table (Meetings & Field Inspections)
        if (!Schema::hasTable('bank_sampah_verifications')) {
            Schema::create('bank_sampah_verifications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('bank_sampah_id')->constrained('bank_sampahs')->onDelete('cascade');
                $table->enum('method', ['online', 'offline'])->default('online');
                $table->dateTime('scheduled_at')->nullable();
                $table->dateTime('completed_at')->nullable();
                $table->enum('result', ['pending', 'verified', 'rejected', 'revision'])->default('pending');
                $table->json('checklist')->nullable(); // JSON verification items
                $table->text('notes')->nullable();
                $table->string('evidence_path')->nullable();
                $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamps();
            });
        }

        // 4. Bank Sampah Admins table
        if (!Schema::hasTable('bank_sampah_admins')) {
            Schema::create('bank_sampah_admins', function (Blueprint $table) {
                $table->id();
                $table->foreignId('bank_sampah_id')->constrained('bank_sampahs')->onDelete('cascade');
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->boolean('is_primary')->default(true);
                $table->timestamp('assigned_at')->useCurrent();
                $table->timestamp('revoked_at')->nullable();
                $table->timestamps();
            });
        }

        // 5. Pickups table (Radius-based pickup workflow)
        if (!Schema::hasTable('pickups')) {
            Schema::create('pickups', function (Blueprint $table) {
                $table->id();
                $table->foreignId('bank_sampah_id')->constrained('bank_sampahs')->onDelete('cascade');
                $table->foreignId('nasabah_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('petugas_id')->nullable()->constrained('users')->onDelete('set null');
                $table->text('address');
                $table->decimal('latitude', 10, 7)->nullable();
                $table->decimal('longitude', 10, 7)->nullable();
                $table->decimal('distance_km', 8, 2)->default(0);
                $table->dateTime('scheduled_at')->nullable();
                $table->enum('status', [
                    'requested', 
                    'validated', 
                    'approved', 
                    'assigned', 
                    'on_the_way', 
                    'arrived', 
                    'weighed', 
                    'completed', 
                    'cancelled', 
                    'failed'
                ])->default('requested');
                $table->text('failure_reason')->nullable();
                $table->string('foto_bukti')->nullable();
                $table->decimal('estimasi_berat', 8, 2)->default(0);
                $table->decimal('berat_aktual', 8, 2)->default(0);
                $table->text('catatan')->nullable();
                $table->timestamps();
            });
        }

        // 6. Wallet Ledgers table
        if (!Schema::hasTable('wallet_ledgers')) {
            Schema::create('wallet_ledgers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('bank_sampah_id')->nullable()->constrained('bank_sampahs')->onDelete('set null');
                $table->ulid('transaction_id')->nullable();
                $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('set null');
                $table->ulid('withdrawal_id')->nullable();
                $table->foreign('withdrawal_id')->references('id')->on('withdrawals')->onDelete('set null');
                $table->enum('type', [
                    'credit',             // Income from verified garbage deposit
                    'debit',              // Withdrawal paid out
                    'withdrawal_hold',    // Amount held during pending withdrawal request
                    'withdrawal_reversal',// Restored amount if withdrawal rejected
                    'adjustment',         // Balance correction by super admin
                    'refund'              // Refunds
                ]);
                $table->decimal('amount', 12, 2);
                $table->decimal('balance_before', 12, 2);
                $table->decimal('balance_after', 12, 2);
                $table->string('reference')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // 7. Audit Logs table
        if (!Schema::hasTable('audit_logs')) {
            Schema::create('audit_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('actor_id')->nullable()->constrained('users')->onDelete('set null');
                $table->string('action'); // e.g. STATUS_CHANGE, VERIFICATION_SUBMIT, ADJUSTMENT
                $table->string('entity_type'); // e.g. BankSampah, Transaction, Withdrawal
                $table->string('entity_id', 36);
                $table->json('old_values')->nullable();
                $table->json('new_values')->nullable();
                $table->text('reason')->nullable();
                $table->string('ip_address')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('wallet_ledgers');
        Schema::dropIfExists('pickups');
        Schema::dropIfExists('bank_sampah_admins');
        Schema::dropIfExists('bank_sampah_verifications');
        Schema::dropIfExists('bank_sampah_documents');

        Schema::table('bank_sampahs', function (Blueprint $table) {
            if (Schema::hasColumn('bank_sampahs', 'status_verifikasi')) $table->dropColumn('status_verifikasi');
            if (Schema::hasColumn('bank_sampahs', 'nomor_registrasi')) $table->dropColumn('nomor_registrasi');
            if (Schema::hasColumn('bank_sampahs', 'penanggung_jawab')) $table->dropColumn('penanggung_jawab');
            if (Schema::hasColumn('bank_sampahs', 'telepon_pj')) $table->dropColumn('telepon_pj');
            if (Schema::hasColumn('bank_sampahs', 'email_pj')) $table->dropColumn('email_pj');
        });
    }
};

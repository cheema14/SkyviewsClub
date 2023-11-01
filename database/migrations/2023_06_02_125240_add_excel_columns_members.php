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
        Schema::table('members', function (Blueprint $table) {
            $table->string('profession',100)->nullable()->after('membership_fee');
            $table->string('base_member_other',100)->nullable()->after('profession');
            $table->string('service_no',100)->nullable()->after('base_member_other');
            $table->decimal('discounted_membership_fee',15,2)->nullable()->after('service_no');
            $table->decimal('membership_security',15,2)->nullable()->after('discounted_membership_fee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('profession');
            $table->dropColumn('base_member_other');
            $table->dropColumn('service_no');
            $table->dropColumn('discounted_membership_fee');
            $table->dropColumn('membership_security');
        });
        
    }
};

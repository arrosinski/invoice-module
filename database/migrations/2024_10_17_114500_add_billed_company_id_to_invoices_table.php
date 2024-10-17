<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddBilledCompanyIdToInvoicesTable extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table): void {
            $table->uuid('billed_company_id')->nullable()->after('company_id');
            $table->foreign('billed_company_id')->references('id')->on('companies')->onDelete('set null');
        });

        // Copy company_id to billed_company_id for existing records
        DB::table('invoices')->update(['billed_company_id' => DB::raw('company_id')]);
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table): void {
            $table->dropForeign(['billed_company_id']);
            $table->dropColumn('billed_company_id');
        });
    }
}

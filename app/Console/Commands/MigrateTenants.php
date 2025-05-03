<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Artisan;

class MigrateTenants extends Command
{
    protected $signature = 'tenants:migrate';
    protected $description = 'Migrate all tenants schemas';

    public function handle()
    {
        // Tenantlar ro'yxatini oling (tenant_a, tenant_b va hokazo)
        $tenants = ['tenant_a', 'tenant_b']; // Buni database yoki config orqali olib kelishingiz mumkin

        foreach ($tenants as $tenant) {
            // Har bir tenant uchun schema'ni o‘rnatish
            DB::statement("SET search_path TO {$tenant}");

            // Tenant uchun migrationsni bajarish
            Artisan::call('migrate', ['--path' => 'database/migrations/tenants', '--force' => true]);

            $this->info("Migrations for {$tenant} are completed.");
        }
    }
}

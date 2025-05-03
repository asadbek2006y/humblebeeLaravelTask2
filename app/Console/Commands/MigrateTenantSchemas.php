<?php

// app/Console/Commands/MigrateTenantSchemas.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class MigrateTenantSchemas extends Command
{
    protected $signature = 'tenants:migrate';
    protected $description = 'Run migrations for all tenant schemas';

    public function handle()
    {
        $schemas = ['tenant_a', 'tenant_b'];

        foreach ($schemas as $schema) {
            DB::statement("SET search_path TO {$schema}");
            $this->info("Running migrations on schema '{$schema}'");

            Artisan::call('migrate', [
                '--path' => '/database/migrations/tenants', // custom path
                '--force' => true,
            ]);

            $this->info("Migrations complete for schema '{$schema}'");
        }
    }
}

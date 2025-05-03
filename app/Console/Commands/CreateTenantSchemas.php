<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateTenantSchemas extends Command
{
    protected $signature = 'tenants:create-schemas';
    protected $description = 'Create schemas for all tenants';

    public function handle()
    {
        $schemas = ['tenant_a', 'tenant_b'];

        foreach ($schemas as $schema) {
            DB::statement("CREATE SCHEMA IF NOT EXISTS {$schema}");
            $this->info("Schema '{$schema}' created.");
        }
    }
}

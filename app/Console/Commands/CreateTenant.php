<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-tenant';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Schema name?');
        $domain = $this->ask('Domain URL?');

        DB::statement("CREATE SCHEMA IF NOT EXISTS {$name}");
        Tenant::create([
            'schema_name' => $name,
            'domain_url' => $domain,
        ]);

        $this->info("Tenant {$domain} with schema {$name} created.");
    }

}

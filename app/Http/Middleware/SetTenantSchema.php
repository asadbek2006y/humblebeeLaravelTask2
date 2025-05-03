<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class SetTenantSchema
{
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $tenantId = $request->route('tenant_id');

        // Skip search_path if using SQLite
        if (env('DB_CONNECTION') !== 'sqlite') {
            $schema = "tenant_" . ($tenantId ?? 'default');
            try {
                DB::statement("SET search_path TO {$schema}, public");
            } catch (\Exception $e) {
                abort(404, 'Tenant schema not found: ' . $schema);
            }
        }

        return $next($request);
    }
}

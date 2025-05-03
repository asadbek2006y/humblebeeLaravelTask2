<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class ConfigController extends Controller
{
    protected function getCurrentSchema(): ?string
    {
        try {
            if (DB::getDriverName() === 'pgsql') {
                $result = DB::select("SELECT current_schema");
                return $result[0]->current_schema ?? null;
            }
        } catch (\Exception $e) {
            // Log warning if needed
            return null;
        }

        return null; // For SQLite or others
    }

    public function show($tenantId, Request $request)
    {
        $this->getCurrentSchema(); // Optional: Just for demonstration

        $configPath = config_path("tenants/tenant_{$tenantId}_config.json");

        if (!File::exists($configPath)) {
            return response()->json(['error' => 'Tenant config not found'], 404);
        }

        $config = json_decode(File::get($configPath), true);

        return response()->json($config);
    }

    public function showPage($tenantId, Request $request)
    {
        $this->getCurrentSchema(); // Optional: Just for demonstration

        $configPath = config_path("tenants/tenant_{$tenantId}_config.json");

        if (!File::exists($configPath)) {
            return response('Tenant not found', 404);
        }

        $config = json_decode(File::get($configPath), true);

        if (!($config['enable_custom_page'] ?? false)) {
            return response('Feature disabled', 403);
        }

        return response("<h1>{$config['page_title']}</h1>");
    }
}

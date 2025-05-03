<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ConfigControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Test uchun config fayl yaratish
        File::ensureDirectoryExists(config_path('tenants'));

        File::put(config_path('tenants/tenant_a_config.json'), json_encode([
            'tenant_id' => 'a',
            'enable_custom_page' => true,
            'page_title' => 'Welcome to A',
        ]));

        File::put(config_path('tenants/tenant_b_config.json'), json_encode([
            'tenant_id' => 'b',
            'enable_custom_page' => false,
            'page_title' => 'Not Enabled',
        ]));
    }

    public function test_can_get_config_for_valid_tenant()
    {
        $response = $this->get('/config/a');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'tenant_id' => 'a',
            'enable_custom_page' => true,
        ]);
    }

    public function test_config_returns_404_for_missing_tenant()
    {
        $response = $this->get('/config/c');
        $response->assertStatus(404);
    }

    public function test_custom_page_is_shown_when_enabled()
    {
        $response = $this->get('/a/page');
        $response->assertStatus(200);
        $response->assertSee('Welcome to A');
    }

    public function test_custom_page_is_forbidden_when_disabled()
    {
        $response = $this->get('/b/page');
        $response->assertStatus(403);
        $response->assertSee('Feature disabled');
    }
}

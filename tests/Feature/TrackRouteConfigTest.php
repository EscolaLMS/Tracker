<?php

namespace EscolaLms\Tracker\Tests\Feature;

use EscolaLms\Core\Tests\CreatesUsers;
use EscolaLms\Tracker\Facades\Tracker;
use EscolaLms\Tracker\Tests\TestCase;
use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class TrackRouteConfigTest extends TestCase
{
    use DatabaseTransactions, CreatesUsers;

    private User $admin;
    private string $route;

    protected function setUp(): void
    {
        parent::setUp();

        Http::fake();

        $this->admin = $this->makeAdmin();
        $this->route = '/api/admin/test-route';
    }

    public function testTrackerEnabled(): void
    {
        Tracker::enable();

        $this->actingAs($this->admin, 'api')->json('GET', $this->route);

        $this->assertDatabaseHas('track_routes', [
            'user_id' => $this->admin->getKey(),
            'full_path' => $this->route,
            'path' => $this->route,
            'method' => 'GET'
        ]);
    }

    public function testTrackerDisabled(): void
    {
        Tracker::disable();

        $this->actingAs($this->admin, 'api')->json('GET', $this->route);

        $this->assertDatabaseMissing('track_routes', [
            'user_id' => $this->admin->getKey(),
            'full_path' => $this->route,
            'path' => $this->route,
            'method' => 'GET'
        ]);
    }

    public function testTrackerIgnoreRoutes(): void
    {
        $ignoreRoute = '/api/admin/ignore-route';
        Tracker::ignoreUris([$ignoreRoute]);

        $this->actingAs($this->admin, 'api')->json('GET', $this->route);
        $this->actingAs($this->admin, 'api')->json('GET', $ignoreRoute);

        $this->assertDatabaseHas('track_routes', [
            'user_id' => $this->admin->getKey(),
            'full_path' => $this->route,
            'path' => $this->route,
            'method' => 'GET'
        ]);
        $this->assertDatabaseMissing('track_routes', [
            'user_id' => $this->admin->getKey(),
            'full_path' => $ignoreRoute,
            'path' => $ignoreRoute,
            'method' => 'GET'
        ]);
    }

    public function testTrackerEmptyIgnoreRoutes(): void
    {
        Tracker::ignoreUris([]);

        $this->actingAs($this->admin, 'api')->json('GET', $this->route);
        $this->assertDatabaseHas('track_routes', [
            'user_id' => $this->admin->getKey(),
            'full_path' => $this->route,
            'path' => $this->route,
            'method' => 'GET'
        ]);
    }

    public function testTrackerPrefix(): void
    {
        Tracker::prefix('/api/new-prefix');

        $this->actingAs($this->admin, 'api')->json('GET', $this->route);
        $this->assertDatabaseMissing('track_routes', [
            'user_id' => $this->admin->getKey(),
            'full_path' => $this->route,
            'path' => $this->route,
            'method' => 'GET'
        ]);

        $route = '/api/new-prefix/test-route';
        $this->actingAs($this->admin, 'api')->json('GET', $route);
        $this->assertDatabaseHas('track_routes', [
            'user_id' => $this->admin->getKey(),
            'full_path' => $route,
            'path' => $route,
            'method' => 'GET'
        ]);
    }

    public function testTrackerEmptyPrefix(): void
    {
        Tracker::prefix(null);

        $this->actingAs($this->admin, 'api')->json('GET', $this->route);
        $this->assertDatabaseHas('track_routes', [
            'user_id' => $this->admin->getKey(),
            'full_path' => $this->route,
            'path' => $this->route,
            'method' => 'GET'
        ]);
    }
}

<?php

namespace EscolaLms\Tracker\Tests\Feature;

use EscolaLms\Core\Tests\CreatesUsers;
use EscolaLms\Tracker\Facades\Tracker;
use EscolaLms\Tracker\Models\TrackRoute;
use EscolaLms\Tracker\Tests\TestCase;
use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
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
        Tracker::ignoreHttpMethods([]);

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
        Tracker::ignoreHttpMethods([]);

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

    public function testTrackerIgnoreMultipleRoutes(): void
    {
        $ignoreRoute1 = '/api/admin/ignore-route/1';
        $ignoreRoute2 = '/api/admin/ignore-route/2';
        Tracker::ignoreUris([$ignoreRoute1, $ignoreRoute2]);
        Tracker::ignoreHttpMethods([]);

        $this->actingAs($this->admin, 'api')->json('GET', $this->route);
        $this->actingAs($this->admin, 'api')->json('GET', $ignoreRoute1);
        $this->actingAs($this->admin, 'api')->json('GET', $ignoreRoute2);

        $this->assertDatabaseHas('track_routes', [
            'user_id' => $this->admin->getKey(),
            'full_path' => $this->route,
            'path' => $this->route,
            'method' => 'GET'
        ]);
        $this->assertDatabaseMissing('track_routes', [
            'user_id' => $this->admin->getKey(),
            'full_path' => $ignoreRoute1,
            'path' => $ignoreRoute1,
            'method' => 'GET'
        ]);
        $this->assertDatabaseMissing('track_routes', [
            'user_id' => $this->admin->getKey(),
            'full_path' => $ignoreRoute2,
            'path' => $ignoreRoute2,
            'method' => 'GET'
        ]);
    }

    public function testTrackerEmptyIgnoreRoutes(): void
    {
        Tracker::ignoreUris([]);
        Tracker::ignoreHttpMethods([]);

        $this->actingAs($this->admin, 'api')->json('GET', $this->route);
        $this->assertDatabaseHas('track_routes', [
            'user_id' => $this->admin->getKey(),
            'full_path' => $this->route,
            'path' => $this->route,
            'method' => 'GET'
        ]);
    }

    public function testTrackerIgnoreHttpMethodsDefaultGet(): void
    {
        $this->actingAs($this->admin, 'api')->json('GET', $this->route);

        $this->assertDatabaseMissing('track_routes', [
            'user_id' => $this->admin->getKey(),
            'full_path' => $this->route,
            'path' => $this->route,
            'method' => 'GET'
        ]);
    }

    public function testTrackerIgnoreHttpMethods(): void
    {
        $ignoreMethod = 'POST';
        Tracker::ignoreHttpMethods([$ignoreMethod]);

        $this->actingAs($this->admin, 'api')->json('GET', $this->route);
        $this->actingAs($this->admin, 'api')->json($ignoreMethod, $this->route);

        $this->assertDatabaseHas('track_routes', [
            'user_id' => $this->admin->getKey(),
            'full_path' => $this->route,
            'path' => $this->route,
            'method' => 'GET'
        ]);
        $this->assertDatabaseMissing('track_routes', [
            'user_id' => $this->admin->getKey(),
            'full_path' => $this->route,
            'path' => $this->route,
            'method' => $ignoreMethod
        ]);
    }

    public function testTrackerIgnoreMultipleMethods(): void
    {
        $allowedMethod = 'POST';
        $ignoreMethod1 = 'GET';
        $ignoreMethod2 = 'DELETE';
        Tracker::ignoreHttpMethods([$ignoreMethod1, $ignoreMethod2]);

        $this->actingAs($this->admin, 'api')->json($allowedMethod, $this->route);
        $this->actingAs($this->admin, 'api')->json($ignoreMethod1, $this->route);
        $this->actingAs($this->admin, 'api')->json($ignoreMethod2, $this->route);

        $this->assertDatabaseHas('track_routes', [
            'user_id' => $this->admin->getKey(),
            'full_path' => $this->route,
            'path' => $this->route,
            'method' => $allowedMethod
        ]);
        $this->assertDatabaseMissing('track_routes', [
            'user_id' => $this->admin->getKey(),
            'full_path' => $this->route,
            'path' => $this->route,
            'method' => $ignoreMethod1
        ]);
        $this->assertDatabaseMissing('track_routes', [
            'user_id' => $this->admin->getKey(),
            'full_path' => $this->route,
            'path' => $this->route,
            'method' => $ignoreMethod2
        ]);
    }

    public function testTrackerEmptyIgnoreMethods(): void
    {
        Tracker::ignoreHttpMethods([]);

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
        Tracker::ignoreHttpMethods([]);

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
        Tracker::ignoreHttpMethods([]);

        $this->actingAs($this->admin, 'api')->json('GET', $this->route);
        $this->assertDatabaseHas('track_routes', [
            'user_id' => $this->admin->getKey(),
            'full_path' => $this->route,
            'path' => $this->route,
            'method' => 'GET'
        ]);
    }
}

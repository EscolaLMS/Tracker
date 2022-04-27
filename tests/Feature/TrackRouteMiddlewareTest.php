<?php

namespace EscolaLms\Tracker\Tests\Feature;

use EscolaLms\Core\Tests\CreatesUsers;
use EscolaLms\Tracker\Facades\Tracker;
use EscolaLms\Tracker\Tests\TestCase;
use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Http;

class TrackRouteMiddlewareTest extends TestCase
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

    public function testTrackRoute(): void
    {
        Tracker::ignoreHttpMethods([]);

        $this->actingAs($this->admin, 'api')->json('GET', $this->route);

        $this->assertDatabaseHas('track_routes', [
            'user_id' => $this->admin->getKey(),
            'full_path' =>  $this->route,
            'path' => $this->route,
            'method' => 'GET'
        ]);
    }

    public function testShouldNotTrackRoute(): void
    {
        $this->actingAs($this->admin, 'api')->json('GET',  $this->route);

        $this->assertDatabaseMissing('track_routes', [
            'user_id' => $this->admin->getKey(),
            'full_path' => $this->route,
            'path' => $this->route,
            'method' => 'GET'
        ]);
    }

    public function testDeleteTrackRoute(): void
    {
        $route = $this->route . '/1';
        $this->actingAs($this->admin, 'api')->json('DELETE',  $route);

        $this->assertDatabaseHas('track_routes', [
            'user_id' => $this->admin->getKey(),
            'full_path' => $route,
            'path' => $route,
            'method' => 'DELETE'
        ]);
    }

    public function testPostTrackRoute(): void
    {
        $this->actingAs($this->admin, 'api')->json('POST',  $this->route, ['foo' => 'bar']);

        $this->assertDatabaseHas('track_routes', [
            'user_id' => $this->admin->getKey(),
            'full_path' => $this->route,
            'path' => $this->route,
            'method' => 'POST'
        ]);
    }

    public function testPatchTrackRoute(): void
    {
        $route = $this->route . '/1';
        $this->actingAs($this->admin, 'api')->json('PATCH',  $route, ['foo' => 'bar']);

        $this->assertDatabaseHas('track_routes', [
            'user_id' => $this->admin->getKey(),
            'full_path' => $route,
            'path' => $route,
            'method' => 'PATCH'
        ]);
    }
}

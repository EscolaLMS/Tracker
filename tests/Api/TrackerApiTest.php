<?php

namespace EscolaLms\Tracker\Tests\Api;

use EscolaLms\Core\Tests\CreatesUsers;
use EscolaLms\Tracker\Database\Seeders\TrackerPermissionSeeder;
use EscolaLms\Tracker\Models\TrackRoute;
use EscolaLms\Tracker\Tests\TestCase;
use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\TestResponse;

class TrackerApiTest extends TestCase
{
    use DatabaseTransactions, CreatesUsers;

    private User $admin;
    private string $route;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(TrackerPermissionSeeder::class);
        $this->admin = $this->makeAdmin();
    }

    public function testIndex(): void
    {
        TrackRoute::factory()->count(10)->create();
        $response = $this->actingAs($this->admin, 'api')->json('GET', 'api/admin/tracks/routes');

        $this->assertApiResponse($response, 10);
    }

    public function testIndexUnauthorized(): void
    {
        $this->json('GET', 'api/admin/tracks/routes')
            ->assertUnauthorized();
    }

    public function testIndexPagination(): void
    {
        TrackRoute::factory()->count(30)->create();
        $response = $this->actingAs($this->admin, 'api')->json('GET', 'api/admin/tracks/routes?page=1&limit=10');

        $this->assertApiResponse($response, 10);
    }

    public function testIndexFilterByUserId(): void
    {
        TrackRoute::factory()->count(10)->create([
            'user_id' => 1,
        ]);
        TrackRoute::factory()->count(5)->create([
            'user_id' => 2,
        ]);
        $response = $this->actingAs($this->admin, 'api')->json('GET', 'api/admin/tracks/routes?user_id=2');

        $this->assertApiResponse($response, 5);
    }

    public function testIndexFilterByPath(): void
    {
        TrackRoute::factory()->count(10)->create();
        TrackRoute::factory()->count(5)->create([
            'path' => 'test-path',
        ]);
        $response = $this->actingAs($this->admin, 'api')->json('GET', 'api/admin/tracks/routes?path=test-path');

        $this->assertApiResponse($response, 5);
    }

    public function testIndexFilterByMethod(): void
    {
        TrackRoute::factory()->count(10)->create([
            'method' => 'DELETE',
        ]);
        TrackRoute::factory()->count(5)->create([
            'method' => 'POST',
        ]);
        $response = $this->actingAs($this->admin, 'api')->json('GET', 'api/admin/tracks/routes?method=POST');

        $this->assertApiResponse($response, 5);
    }

    private function assertApiResponse(TestResponse $response, int $count): void
    {
        $response->assertOk();
        $response->assertJsonCount($count, 'data');
        $response->assertJsonStructure([
            'data' => [[
                'id',
                'user_id',
                'path',
                'full_path',
                'method',
                'extra',
            ]]
        ]);
    }
}

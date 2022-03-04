<?php

namespace EscolaLms\Tracker\Tests\Api;

use Carbon\Carbon;
use EscolaLms\Core\Models\User;
use EscolaLms\Core\Tests\CreatesUsers;
use EscolaLms\Tracker\Database\Seeders\TrackerPermissionSeeder;
use EscolaLms\Tracker\Models\TrackRoute;
use EscolaLms\Tracker\Tests\TestCase;
use Illuminate\Contracts\Auth\Authenticatable as AuthUser;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;

class TrackerApiTest extends TestCase
{
    use DatabaseTransactions, CreatesUsers, WithFaker;

    private AuthUser $admin;
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
        $user = User::factory()->create();
        TrackRoute::factory()->count(10)->create([
            'user_id' => $user->getKey(),
        ]);
        TrackRoute::factory()->count(5)->create();
        $response = $this->actingAs($this->admin, 'api')->json('GET', 'api/admin/tracks/routes?user_id=' . $user->getKey());

        $this->assertApiResponse($response, 10);
        $this->assertEquals($user->getKey(), $response->getData()->data[0]->user->id);
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

    public function testIndexFilterByDates(): void
    {
        TrackRoute::factory()->count(10)->create([
            'created_at' => $this->faker->dateTimeBetween('-30 days')
        ]);
        TrackRoute::factory()->count(5)->create([
            'created_at' => $this->faker->dateTimeBetween('-3 months', '-2 months')
        ]);
        TrackRoute::factory()->count(5)->create([
            'created_at' => $this->faker->dateTimeBetween('+1 months', '+2 months')
        ]);

        $dateFrom = Carbon::now()->subDays(30);
        $dateTo = Carbon::now();
        $response = $this->actingAs($this->admin, 'api')
            ->json('GET', 'api/admin/tracks/routes?date_from=' . $dateFrom . '&date_to=' . $dateTo);

        $this->assertApiResponse($response, 10);
    }

    public function testIndexFilterByDateFrom(): void
    {
        TrackRoute::factory()->count(10)->create([
            'created_at' => $this->faker->dateTimeBetween('-30 days')
        ]);
        TrackRoute::factory()->count(5)->create([
            'created_at' => $this->faker->dateTimeBetween('-3 months', '-2 months')
        ]);

        $dateFrom = Carbon::now()->subDays(30);
        $response = $this->actingAs($this->admin, 'api')
            ->json('GET', 'api/admin/tracks/routes?date_from=' . $dateFrom);

        $this->assertApiResponse($response, 10);
    }

    public function testIndexFilterByDateTo(): void
    {
        TrackRoute::factory()->count(10)->create([
            'created_at' => $this->faker->dateTimeBetween('-30 days', '-15 days')
        ]);
        TrackRoute::factory()->count(5)->create([
            'created_at' => Carbon::now()
        ]);

        $dateTo = Carbon::now()->subDays(15);
        $response = $this->actingAs($this->admin, 'api')
            ->json('GET', 'api/admin/tracks/routes?date_to=' . $dateTo);

        $this->assertApiResponse($response, 10);
    }

    private function assertApiResponse(TestResponse $response, int $count): void
    {
        $response->assertOk();
        $response->assertJsonCount($count, 'data');
        $response->assertJsonStructure([
            'data' => [[
                'id',
                'user' => [
                    'first_name',
                    'last_name',
                    'email',
                ],
                'path',
                'full_path',
                'method',
                'extra',
            ]]
        ]);
    }
}

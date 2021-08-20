<?php

namespace Tests\Feature\Api;

use App\Models\Evaluation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class EvaluationTest extends TestCase
{
    /**
     * Test empty response
     *
     * @return void
     */
    public function test_get_evaluations_empty()
    {
        $response = $this->getJson('/evaluations/fake-company');

        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
    }


    /**
     * Get all company evaluations
     *
     * @return void
     */
    public function test_get_evaluations_company()
    {
        $uuid = Str::uuid();
        Evaluation::factory()->count(7)->create(['company_uuid' => $uuid]);

        $response = $this->getJson("/evaluations/$uuid");

        $response->assertStatus(200);
        $response->assertJsonCount(7, 'data');
    }

    /**
     *Test validation Store company
     *
     * @return void
     */
    public function test_store_evaluation_error()
    {
        $uuid = 'fake-company';

        Evaluation::factory()->count(7)->create(['company_uuid' => $uuid]);

        $response = $this->postJson("/evaluations/$uuid");

        $response->assertStatus(422);
    }


    /**
     *Test validation Store company
     *
     * @return void
     */
    public function test_store_evaluation()
    {
        $uuid = 'fake-uuid';

        Evaluation::factory()->count(7)->create(['company_uuid' => $uuid]);

        $response = $this->postJson("/evaluations/$uuid", [
            'company_uuid' => (string) Str::uuid(),
            'comment' => 'New Company',
            'stars' => '5'
        ]);

        $response->assertStatus(404);
    }
}

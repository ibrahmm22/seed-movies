<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class MovieTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_seed_movies()
    {
        $result = Artisan::call('sync:movies');

    }
    /** @test */
    public function test_list_movies()
    {
        $response = $this->get('/movies');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'current_page',
                'data',
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total'
            ]);
    }
}

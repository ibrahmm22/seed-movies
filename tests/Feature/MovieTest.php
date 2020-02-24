<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Ibrahim\Movie\Repositories\MovieDataSourceRepository;
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
        $mockingBody = [
            "page" => 1,
            "total_results" => 6917,
            "total_pages" => 346,
            "results" => [
                [
                    "popularity" => 18.132,
                    "vote_count" => 2210,
                    "video" => false,
                    "poster_path" => "/2CAL2433ZeIihfX1Hb2139CX0pW.jpg",
                    "id" => 19404,
                    "adult" => false,
                    "backdrop_path" => "/pVGzV02qmHVoKx9ehBNy7m2u5fs.jpg",
                    "original_language" => "hi",
                    "original_title" => "दिलवाले दुल्हनिया ले जायेंगे",
                    "genre_ids" => [
                        35,
                        18,
                        10749
                    ],
                    "title" => "Dilwale Dulhania Le Jayenge",
                    "vote_average" => 8.8,
                    "overview" => "Raj is a rich, carefree, happy-go-lucky second generation NRI. Simran is the daughter of Chaudhary Baldev Singh, who in spite of being an NRI is very strict about adherence to Indian values. Simran has left for India to be married to her childhood fiancé. Raj leaves for India with a mission at his hands, to claim his lady love under the noses of her whole family. Thus begins a saga.",
                    "release_date" => "1995-10-20"
                ]
            ]
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($mockingBody)),
            new Response(200, [], json_encode($mockingBody)),
            new Response(200, [], json_encode($mockingBody)),
            new Response(200, [], json_encode($mockingBody)),
            new Response(200, [], json_encode($mockingBody)),
            new Response(200, [], json_encode($mockingBody)),
            new Response(200, [], json_encode($mockingBody)),
            new Response(200, [], json_encode($mockingBody)),
            new Response(200, [], json_encode($mockingBody)),
            new Response(200, [], json_encode($mockingBody)),
            new Response(200, [], json_encode($mockingBody))
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        $someClass = new MovieDataSourceRepository($client);

        $response = $someClass->syncMovies();
        $this->assertTrue($response);
        $this->assertDatabaseHas('movies', [
            "id" => 1,
            "movie_id" => 19404,
            "popularity" => 18.132,
            "vote_count" => 2210,
            "video" => false,
            "poster_path" => "/2CAL2433ZeIihfX1Hb2139CX0pW.jpg",
            "adult" => false,
            "backdrop_path" => "/pVGzV02qmHVoKx9ehBNy7m2u5fs.jpg",
            "original_language" => "hi"

        ]);

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

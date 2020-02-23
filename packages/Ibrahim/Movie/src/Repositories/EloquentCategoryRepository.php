<?php

namespace Ibrahim\Movie\Repositories;

use GuzzleHttp\Client;
use Ibrahim\Movie\Models\Category;
use Ibrahim\Movie\Repositories\Contracts\RepositoryInterface;

class EloquentCategoryRepository implements RepositoryInterface
{
    public $model, $client;

    /**
     * EloquentCategoryRepository constructor.
     * @param $model
     * @param $client
     */
    public function __construct(Category $model, Client $client)
    {
        $this->model = $model;
        $this->client = $client;
    }

    public function syncCategories()
    {
        $url = config('movie.movie_url') . '/genre/movie/list?api_key=' . config('movie.api_key');
        $response = $this->client->request('GET', $url);
        $categories = json_decode($response->getBody());
        foreach ($categories->genres as $genre) {
            $genre = (array)$genre;
            $genre['movie_category_id'] = $genre['id'];
            unset($genre['id']);
            $this->model->updateOrCreate(['movie_category_id' => $genre['movie_category_id']], $genre);

        }
    }
}

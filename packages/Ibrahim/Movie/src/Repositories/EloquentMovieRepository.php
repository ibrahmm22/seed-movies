<?php

namespace Ibrahim\Movie\Repositories;

use Ibrahim\Movie\Models\Movie;
use Ibrahim\Movie\Repositories\Contracts\RepositoryInterface;
use Illuminate\Support\Str;

class EloquentMovieRepository implements RepositoryInterface
{
    public $model, $client;

    /**
     * EloquentMovieRepository constructor.
     * @param $model
     */
    public function __construct(Movie $model)
    {
        $this->model = $model;
    }

    public function insert($data)
    {
        foreach ($data as $movie) {
            $categories = $movie->genre_ids;
            $movie = (array)$movie;
            $movie['movie_id'] = $movie['id'];
            unset($movie['id']);
            $movie = $this->model->updateOrCreate(['movie_id' => $movie['movie_id']], $movie);
            $movie->categories()->sync($categories);
        }
    }

    public function all($data)
    {
        $filters = $this->prepareDataFilter(array_keys($data));
        $query = $this->model->query();
        if (isset($data['category_id']) && $data['category_id']) {
            $query->whereHas('categories', function ($query) use ($data) {
                $query->where(['category_id' => $data['category_id']]);
            });
        }
        foreach ($filters as $column => $sortType) {
            $query->sort($this->mapFilter($column), $sortType);
        }
        return $query->paginate();
    }

    private function prepareDataFilter($params)
    {
        $filters = [];
        foreach ($params as $param ) {

            if (Str::contains($param, "|")) {
                $queryParam = explode("|", $param);
                $filters[$queryParam[0]] =$queryParam[1];
            }
        }
        return $filters;
    }

    private function mapFilter($filter)
    {
        $keys = [
            'popular' => 'popularity',
            'rated' => 'vote_count'
        ];
        return $keys[$filter];
    }
}

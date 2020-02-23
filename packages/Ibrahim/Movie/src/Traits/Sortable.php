<?php

namespace Ibrahim\Movie\Traits;

trait Sortable
{

    public function scopeSort($query, $column, $sortType)
    {
        return $query->orderBy($column, $sortType);
    }
}

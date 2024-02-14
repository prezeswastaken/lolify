<?php

namespace App\Repositories;

use App\Http\Requests\StoreChampionRequest;
use App\Models\Champion;

/**
 * Creates champion and returns it
 */
class ChampionRepository
{
    public function create(StoreChampionRequest $request)
    {
        $championData = $request->only(['name', 'description']);

        $champion = Champion::create($championData);

        return $champion;
    }
}

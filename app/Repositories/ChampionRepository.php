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
        $roleIds = $request->roles;
        $championData = $request->only(['name', 'description', 'title']);

        $image = $request->file('image_file');
        if ($image) {
            $extension = '.jpg';
            $fileName = $championData['name'].' - '.strval(time()).$extension;
            $fullPath = 'public/images';
            $championData['image_link'] = url('/')."/storage/images/$fileName";

            $image->storeAs($fullPath, $fileName);
        }

        $champion = Champion::create($championData);

        $champion->roles()->attach($roleIds);

        return $champion;
    }
}

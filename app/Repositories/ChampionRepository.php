<?php

namespace App\Repositories;

use App\Http\Requests\StoreChampionRequest;
use App\Models\Champion;

/**
 * Creates champion and returns it
 */
class ChampionRepository
{
    public function create(StoreChampionRequest $request, SkillRepository $skillRepository)
    {
        // Extract skills from request
        $q = ['name' => $request['q_name'], 'image_file' => $request->file('q_image_file'), 'letter' => 'q'];
        $w = ['name' => $request['w_name'], 'image_file' => $request->file('w_image_file'), 'letter' => 'w'];
        $e = ['name' => $request['e_name'], 'image_file' => $request->file('e_image_file'), 'letter' => 'e'];
        $r = ['name' => $request['r_name'], 'image_file' => $request->file('r_image_file'), 'letter' => 'r'];
        $passive = ['name' => $request['passive_name'], 'image_file' => $request->file('passive_image_file'), 'letter' => 'passive'];
        $skills = [$q, $w, $e, $r, $passive];

        $roleIds = $request->roles;
        //$roleIds = [1, 2];
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

        foreach ($skills as $skill) {
            $skillRepository->create($champion, $skill);
        }

        return $champion;
    }
}

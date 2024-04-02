<?php

namespace App\Repositories;

use App\Http\Requests\StoreChampionRequest;
use App\Http\Resources\ShowChampionResource;
use App\Models\Champion;

class ChampionRepository
{
    public function __construct(
        private LogRepository $logRepository,
        private SkinRepository $skinRepository,
        private SkillRepository $skillRepository,
    ) {
    }

    public function create(
        StoreChampionRequest $request,
    ) {
        $skins = [
            $request->file('skin_1_image_file'),
            $request->file('skin_2_image_file'),
            $request->file('skin_3_image_file'),
            $request->file('skin_4_image_file'),
        ];

        $q = ['name' => $request['q_name'], 'image_file' => $request->file('q_image_file'), 'letter' => 'q'];
        $w = ['name' => $request['w_name'], 'image_file' => $request->file('w_image_file'), 'letter' => 'w'];
        $e = ['name' => $request['e_name'], 'image_file' => $request->file('e_image_file'), 'letter' => 'e'];
        $r = ['name' => $request['r_name'], 'image_file' => $request->file('r_image_file'), 'letter' => 'r'];
        $passive = ['name' => $request['passive_name'], 'image_file' => $request->file('passive_image_file'), 'letter' => 'passive'];
        $skills = [$q, $w, $e, $r, $passive];

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

        foreach ($skills as $skill) {
            $this->skillRepository->create($champion, $skill);
        }

        foreach (array_values($skins) as $i => $skinImageFile) {
            if ($skinImageFile) {
                $this->skinRepository->create($champion, $skinImageFile, $i);
            }
        }

        return $champion;
    }

    public function full()
    {
        $champions = Champion::all();

        $championsFull = $champions->map(fn ($champion) => new ShowChampionResource($champion));

        return $championsFull;

    }

    /**
     * Returns top 3 most liked champions
     *
     * @return \Illuminate\Database\Eloquent\Collection|Champion[]
     */
    public function top3()
    {
        /**
         * @var \Illuminate\Database\Eloquent\Collection<Champion>
         */
        $topChampions = Champion::withCount('users')
            ->orderByDesc('users_count')
            ->limit(3)
            ->get();

        return $topChampions;
    }
}

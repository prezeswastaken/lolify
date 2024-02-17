<?php

namespace App\Repositories;

use App\Models\Champion;

class SkillRepository
{
    public function create(Champion $champion, $skill)
    {
        $name = $skill['name'];
        $image_file = $skill['image_file'];
        $letter = $skill['letter'];

        $extension = '.jpg';
        $fileName = $name.' - '.$champion->name.' - '.strval(time()).$extension;
        $fullPath = 'public/images/skills';
        $image_link = url('/')."/storage/images/skills/$fileName";

        $image_file->storeAs($fullPath, $fileName);

        $champion->skills()->create(['name' => $name, 'image_link' => $image_link, 'letter' => $letter]);
    }
}

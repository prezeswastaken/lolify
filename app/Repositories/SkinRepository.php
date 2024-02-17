<?php

namespace App\Repositories;

use App\Models\Champion;

class SkinRepository
{
    public function create(Champion $champion, $skinImageFile, int $i)
    {
        $extension = '.jpg';
        $fileName = $champion['name']." - skin $i - ".strval(time()).$extension;
        $fullPath = 'public/images/skins';
        $imageLink = url('/')."/storage/images/skins/$fileName";

        $skinImageFile->storeAs($fullPath, $fileName);

        $champion->skins()->create(['image_link' => $imageLink]);
    }
}

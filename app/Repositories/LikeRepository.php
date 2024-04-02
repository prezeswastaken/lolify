<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Champion;
use JWTAuth;

class LikeRepository
{
    public function __construct(
        private LogRepository $logRepository,
    ) {
    }

    /**
     * Adds certain champion to current user's likes
     */
    public function like(Champion $champion)
    {
        /**
         * @var User $user
         */
        $user = JWTAuth::user();

        /**
         * @var bool $alreadyLikes
         */
        $alreadyLikes = $user->likes()->whereId($champion->id)->exists();
        if ($alreadyLikes === true) {
            return;
        }

        // syncWithoutDetaching ensures that user can like a champion only once
        /** @var User $user */
        $user->likes()->syncWithoutDetaching([$champion->id]);

        $this->logRepository->createUserLog(
            UserLog::Like,
            $champion->name,
        );
    }

    public function dislike(Champion $champion)
    {
        /**
         * @var User $user
         */
        $user = JWTAuth::user();

        /**
         * @var bool $alreadyLikes
         */
        $alreadyLikes = $user->likes()->whereId($champion->id)->exists();
        if ($alreadyLikes === false) {
            return;
        }

        // Remove the association between the user and the champion
        $user->likes()->detach($champion->id);

        $this->logRepository->createUserLog(
            UserLog::Dislike,
            $champion->name,
        );
    }
}

<?php

namespace App\Repositories;

use JWTAuth;

enum UserLog
{
    case Like;
    case Dislike;
}

class LogRepository
{
    public function createUserLog(UserLog $action, string $championName)
    {
        /**
         * @var \App\Models\User
         */
        $user = JWTAuth::user();

        /**
         * @var string
         */
        $actionMessage = match ($action) {
            UserLog::Like => 'liked',
            UserLog::Dislike => 'disliked',
        };

        $message = "$user->name $actionMessage $championName";

        $user->logs()->create(['text' => $message]);
    }
}

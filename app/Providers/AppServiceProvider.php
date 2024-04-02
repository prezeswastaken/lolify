<?php

namespace App\Providers;

use App\Repositories\ChampionRepository;
use App\Repositories\LikeRepository;
use App\Repositories\LogRepository;
use App\Repositories\SkillRepository;
use App\Repositories\SkinRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(UserRepository::class, function () {
            return new UserRepository();
        });

        $this->app->singleton(ChampionRepository::class, function ($app) {
            return new ChampionRepository(
                $app->make(LogRepository::class),
                $app->make(SkinRepository::class),
                $app->make(SkillRepository::class),
            );
        });

        $this->app->singleton(SkinRepository::class, function () {
            return new SkinRepository();
        });

        $this->app->singleton(SkillRepository::class, function () {
            return new SkillRepository();
        });

        $this->app->singleton(LogRepository::class, function () {
            return new LogRepository();
        });

        $this->app->singleton(LikeRepository::class, function () {
            return new LikeRepository(
                $this->app->make(LogRepository::class),
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }
}

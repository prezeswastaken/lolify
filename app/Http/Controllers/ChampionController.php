<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChampionRequest;
use App\Http\Requests\UpdateChampionRequest;
use App\Models\Champion;
use App\Repositories\ChampionRepository;
use App\Repositories\SkillRepository;
use App\Repositories\SkinRepository;

class ChampionController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'register', 'show', 'skills']]);
    }

    /**
     * @unauthenticated
     * Display a listing of the resource.
     */
    public function index()
    {
        return Champion::all();
    }

    /**
     * Create new champion
     *
     * @bodyParam name string required Example: Yasuo
     * @bodyParam description string Example: The NoobChamp
     */
    public function store(StoreChampionRequest $request, ChampionRepository $championRepository, SkillRepository $skillRepository, SkinRepository $skinRepository)
    {
        return $championRepository->create($request, $skillRepository, $skinRepository);
    }

    /**
     * Get champion by champion id
     *
     * @unauthenticated
     */
    public function show(Champion $champion)
    {
        return $champion;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChampionRequest $request, Champion $champion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Champion $champion)
    {
        $champion->delete();
    }

    public function skills(Champion $champion)
    {
        return $champion->skills;
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChampionRequest;
use App\Http\Requests\UpdateChampionRequest;
use App\Models\Champion;
use App\Repositories\ChampionRepository;

class ChampionController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'register']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChampionRequest $request, ChampionRepository $championRepository)
    {
        return $championRepository->create($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Champion $champion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Champion $champion)
    {
        //
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
        //
    }
}

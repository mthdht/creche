<?php

namespace App\Http\Controllers;

use App\Models\health;
use App\Http\Requests\StorehealthRequest;
use App\Http\Requests\UpdatehealthRequest;

class HealthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorehealthRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(health $health)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(health $health)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatehealthRequest $request, health $health)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(health $health)
    {
        //
    }
}

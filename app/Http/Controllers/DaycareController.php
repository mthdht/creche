<?php

namespace App\Http\Controllers;

use App\Models\Daycare;
use App\Http\Requests\StoreDaycareRequest;
use App\Http\Requests\UpdateDaycareRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class DaycareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('daycares/Index', [
            'daycares' => Auth::user()->daycares->loadCount('children'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('daycares/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDaycareRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Daycare $daycare)
    {
        return Inertia::render('daycares/Show', [
            'daycare' => $daycare->load('children'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Daycare $daycare)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDaycareRequest $request, Daycare $daycare)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Daycare $daycare)
    {
        //
    }
}

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
        $data = $request->validated();
        
        $daycare = $request->user()->daycares()->create($data);

        return redirect()->route('daycares.show', $daycare);
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
        return Inertia::render('daycares/Edit', [
            'daycare' => $daycare->load('children'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDaycareRequest $request, Daycare $daycare)
    {
        $data = $request->validated();
        
        $daycare->update($data);

        return redirect()->route('daycares.show', $daycare);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Daycare $daycare)
    {
        $daycare->delete();

        return redirect()->route('daycares.index');
    }
}

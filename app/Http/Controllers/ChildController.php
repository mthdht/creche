<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Daycare;
use App\Models\Health;
use App\Http\Requests\StoreChildRequest;
use App\Http\Requests\UpdateChildRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ChildController extends Controller
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
    public function create(Daycare $daycare)
    {
        if (Auth::user()->can('act', $daycare)) {
            return Inertia::render('children/Create', [
                'daycare' => $daycare
            ]);
        }

        return back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChildRequest $request, Daycare $daycare)
    {
        if (Auth::user()->can('act', $daycare)) {
            $data = $request->validated();

            $health = new Health();
            $child = $daycare->children()->create($data);
            $child->health()->save($health);

            return redirect()->route('daycares.children.show', [$daycare, $child]);
        }

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Daycare $daycare, Child $child)
    {
        $child->load(['guardians', 'health', 'additionalNotes', 'lastFiveDaysTransmissions']);

        if (Auth::user()->can('act', $daycare)) {
            return Inertia::render('children/Show', [
                'daycare' => $daycare,
                'child' => $child
            ]);
        }

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Daycare $daycare, Child $child)
    {
        return Inertia::render('children/Edit', [
            'daycare' => $daycare,
            'child' => $child
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChildRequest $request, Daycare $daycare, Child $child)
    {
        if (Auth::user()->can('act', $daycare)) {
            $data = $request->validated();

            $child->update($data);

            return redirect()->route('daycares.children.show', [$daycare, $child]);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Daycare $daycare, Child $child)
    {
        if (Auth::user()->can('act', $daycare)) {
            $child->delete();

            return redirect()->route('daycares.show', $daycare);
        }

        return back();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTransmissionRequest;
use App\Http\Requests\UpdateTransmissionRequest;
use App\Models\Transmission;
use App\Models\Child;
use App\Models\Daycare;
use Inertia\Inertia;

class TransmissionController extends Controller
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
    public function create(Daycare $daycare, Child $child)
    {
        if (Auth::user()->can('act', $daycare)) {
            return Inertia::render('transmissions/Create', [
                'child' => $child,
                'daycare' => $daycare
            ]);
        }

        return back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransmissionRequest $request, Daycare $daycare, Child $child)
    {
        if (Auth::user()->can('act', $daycare)) {
            $child->transmissions()->create($request->all());
        }

        return redirect()->route('daycares.children.show', [$daycare, $child, 'tab' => 'transmissions']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transmission $transmission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Daycare $daycare, Child $child, Transmission $transmission)
    {
        if (Auth::user()->can('act', $daycare)) {
            return Inertia::render('transmissions/Edit', [
                'child' => $child,
                'daycare' => $daycare,
                'transmission' => $transmission
            ]);
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransmissionRequest $request, Daycare $daycare, Child $child, Transmission $transmission)
    {
        if (Auth::user()->can('act', $daycare)) {
            $transmission->update($request->all());
        }

        return redirect()->route('daycares.children.show', [$daycare, $child, 'tab' => 'transmissions']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Daycare $daycare, Child $child, Transmission $transmission)
    {
        if (Auth::user()->can('act', $daycare)) {
            $transmission->delete();

            return redirect()->back();
        }

        return back();
    }
}

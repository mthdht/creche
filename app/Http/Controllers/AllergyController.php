<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreAllergyRequest;
use App\Http\Requests\UpdateAllergyRequest;
use App\Models\Allergy;
use App\Models\Illness;
use App\Models\Child;
use App\Models\Daycare;
use Inertia\Inertia;

class AllergyController extends Controller
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
            return Inertia::render('allergies/Create', [
                'child' => $child,
                'daycare' => $daycare
            ]);
        }

        return back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAllergyRequest $request, Daycare $daycare, Child $child)
    {
        if (Auth::user()->can('act', $daycare)) {
            $child->health->allergies()->create([
                'name' => $request->name,
                'description' => $request->description,
                'severity' => $request->severity
            ]);
        }

        return redirect()->route('daycares.children.show', [$daycare, $child]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Allergy $allergy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Daycare $daycare, Child $child, Allergy $allergy)
    {
        if (Auth::user()->can('act', $daycare)) {
            return Inertia::render('allergies/Edit', [
                'child' => $child,
                'daycare' => $daycare,
                'allergy' => $allergy
            ]);
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAllergyRequest $request, Daycare $daycare, Child $child, Allergy $allergy)
    {
        if (Auth::user()->can('act', $daycare)) {
            $allergy->update([
                 'name' => $request->name,
                 'description' => $request->description,
                 'note' => $request->note
             ]);
         }
 
         return redirect()->route('daycares.children.show', [$daycare, $child]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Daycare $daycare, Child $child, Allergy $allergy)
    {
        if (Auth::user()->can('act', $daycare)) {
            $allergy->delete();

            return redirect()->back();
        }

        return back();
    }
}

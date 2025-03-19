<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreMedicationRequest;
use App\Http\Requests\UpdateMedicationRequest;
use App\Models\Medication;
use App\Models\Child;
use App\Models\Daycare;
use Inertia\Inertia;

class MedicationController extends Controller
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
            return Inertia::render('medications/Create', [
                'child' => $child,
                'daycare' => $daycare
            ]);
        }

        return back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedicationRequest $request, Daycare $daycare, Child $child)
    {
        if (Auth::user()->can('act', $daycare)) {
            $child->health->medications()->create([
                'name' => $request->name,
                'dosage' => $request->dosage,
                'note' => $request->note
            ]);
        }

        return redirect()->route('daycares.children.show', [$daycare, $child]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Medication $medication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Daycare $daycare, Child $child, Medication $medication)
    {
        if (Auth::user()->can('act', $daycare)) {
            return Inertia::render('medications/Edit', [
                'child' => $child,
                'daycare' => $daycare,
                'medication' => $medication
            ]);
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedicationRequest $request, Daycare $daycare, Child $child, Medication $medication)
    {
        if (Auth::user()->can('act', $daycare)) {
            $medication->update([
                 'name' => $request->name,
                 'dosage' => $request->dosage,
                 'note' => $request->note
             ]);
         }
 
         return redirect()->route('daycares.children.show', [$daycare, $child]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Daycare $daycare, Child $child, Medication $medication)
    {
        if (Auth::user()->can('act', $daycare)) {
            $medication->delete();

            return redirect()->back();
        }

        return back();
    }
}

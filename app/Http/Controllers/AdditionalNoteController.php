<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreAdditionalNoteRequest;
use App\Http\Requests\UpdateAdditionalNoteRequest;
use App\Models\AdditionalNote;
use App\Models\Child;
use App\Models\Daycare;
use Inertia\Inertia;

class AdditionalNoteController extends Controller
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
            return Inertia::render('notes/Create', [
                'child' => $child,
                'daycare' => $daycare
            ]);
        }

        return back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdditionalNoteRequest $request, Daycare $daycare, Child $child)
    {
        if (Auth::user()->can('act', $daycare)) {
            $child->additionalNotes()->create([
                'note' => $request->note,
                'severity' => $request->severity
            ]);
        }

        return redirect()->route('daycares.children.show', [$daycare, $child]);
    }

    /**
     * Display the specified resource.
     */
    public function show(AdditionalNote $additionalNote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Daycare $daycare, Child $child, AdditionalNote $additionalNote)
    {
        if (Auth::user()->can('act', $daycare)) {
            return Inertia::render('notes/Edit', [
                'child' => $child,
                'daycare' => $daycare,
                'additional_note' => $additionalNote
            ]);
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdditionalNoteRequest $request,Daycare $daycare, Child $child, AdditionalNote $additionalNote)
    {
        if (Auth::user()->can('act', $daycare)) {
            $additionalNote->update([
                 'note' => $request->note,
                'severity' => $request->severity
             ]);
         }
 
         return redirect()->route('daycares.children.show', [$daycare, $child]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Daycare $daycare, Child $child, AdditionalNote $additionalNote)
    {
        if (Auth::user()->can('act', $daycare)) {
            $additionalNote->delete();

            return redirect()->back();
        }

        return back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIllnessRequest;
use App\Http\Requests\UpdateIllnessRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Illness;
use App\Models\Child;
use App\Models\Daycare;
use Inertia\Inertia;

class IllnessController extends Controller
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
            return Inertia::render('illnesses/Create', [
                'child' => $child,
                'daycare' => $daycare
            ]);
        }

        return back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIllnessRequest $request, Daycare $daycare, Child $child)
    {
        if (Auth::user()->can('act', $daycare)) {
            $illness = $child->health->illnesses()->create([
                'name' => $request->name,
                'description' => $request->description,
                'note' => $request->note
            ]);
        }

        return redirect()->route('daycares.children.show', [$daycare, $child]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Illness $illness)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Daycare $daycare, Child $child, Illness $illness)
    {
        if (Auth::user()->can('act', $daycare)) {
            return Inertia::render('illnesses/Edit', [
                'child' => $child,
                'daycare' => $daycare,
                'illness' => $illness
            ]);
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIllnessRequest $request, Daycare $daycare, Child $child, Illness $illness)
    {
        if (Auth::user()->can('act', $daycare)) {
            $illness->update([
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
    public function destroy(Daycare $daycare, Child $child, Illness $illness)
    {
        if (Auth::user()->can('act', $daycare)) {
            $illness->delete();

            return redirect()->back();
        }

        return back();
    }
}

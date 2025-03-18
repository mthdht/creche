<?php

namespace App\Http\Controllers;

use App\Models\Daycare;
use App\Http\Requests\StoreDaycareRequest;
use App\Http\Requests\UpdateDaycareRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\request;

class DaycareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->can('viewAny', Daycare::class)) {
            return Inertia::render('daycares/Index', [
                'daycares' => Auth::user()->daycares->loadCount('children'),
            ]);
        }

        return back();
        
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->can('create', Daycare::class)) {
            return Inertia::render('daycares/Create');
        }
        
        return back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDaycareRequest $request)
    {
        if (Auth::user()->can('create', Daycare::class)) {
            $data = $request->validated();
        
            $daycare = $request->user()->daycares()->create($data);

            return redirect()->route('daycares.show', $daycare);
        }
        
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Daycare $daycare)
    {
        if (Auth::user()->can('act', $daycare)) {
            return Inertia::render('daycares/Show', [
                'daycare' => $daycare->load('children'),
            ]);
        }

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Daycare $daycare)
    {
        if (Auth::user()->can('act', $daycare)) {
            return Inertia::render('daycares/Edit', [
                'daycare' => $daycare->load('children'),
            ]);
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDaycareRequest $request, Daycare $daycare)
    {
        if (Auth::user()->can('act', $daycare)) {
            $data = $request->validated();
        
            $daycare->update($data);
    
            return redirect()->route('daycares.show', $daycare);
        }

        return back();
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Daycare $daycare)
    {
        if (Auth::user()->can('act', $daycare)) {
            $daycare->delete();

            return redirect()->route('daycares.index');
        }

        return back();
    }
}

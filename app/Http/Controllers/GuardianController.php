<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use App\Models\Child;
use App\Models\Daycare;
use App\Models\User;
use App\Http\Requests\StoreGuardianRequest;
use App\Http\Requests\UpdateGuardianRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class GuardianController extends Controller
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
            return Inertia::render('guardians/Create', [
                'child' => $child,
                'daycare' => $daycare
            ]);
        }

        return back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGuardianRequest $request, Daycare $daycare, Child $child)
    {

        if (Auth::user()->can('act', $daycare)) {
            $user = User::create([
                'name' => $request->last_name . ' ' . $request->first_name,
                'email' => $request->email, 
                'phone' => $request->phone,
                'password' => Hash::make($request->last_name . '1234' . $request->first_name)
            ]);
    
            $user->profile()->create($request->except('email'));
            $child->guardians()->save($user);
    
            return redirect()->route('daycares.children.show', [$daycare, $child]);
        }

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(User $guardian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Daycare $daycare, Child $child, User $guardian)
    {
        if (Auth::user()->can('act', $daycare)) {
            return Inertia::render('guardians/Edit', [
                'child' => $child,
                'daycare' => $daycare,
                'guardian' => $guardian
            ]);
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGuardianRequest $request, Daycare $daycare, Child $child, User $guardian)
    {
        if (Auth::user()->can('act', $daycare)) {
            $guardian->update([
                'name' => $request->last_name . ' ' . $request->first_name,
                'email' => $request->email,
            ]);
    
            $guardian->profile()->update($request->except(['name', 'email']));
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Daycare $daycare, Child $child, User $guardian, )
    {
        if (Auth::user()->can('act', $daycare)) {
            $guardian->delete();

            return redirect()->back();
        }

        return back();
    }
}

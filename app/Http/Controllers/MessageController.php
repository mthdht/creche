<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Models\Child;
use App\Models\Daycare;
use Inertia\Inertia;

class MessageController extends Controller
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
            return Inertia::render('messages/Create', [
                'child' => $child,
                'daycare' => $daycare
            ]);
        }

        return back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMessageRequest $request, Daycare $daycare, Child $child)
    {
        if (Auth::user()->can('act', $daycare)) {
            $child->messages()->create($request->all());
        }

        return redirect()->route('daycares.children.show', [$daycare, $child, 'tab' => 'messages']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Daycare $daycare, Child $child, Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Daycare $daycare, Child $child, Message $message)
    {
        if (Auth::user()->can('act', $daycare)) {
            return Inertia::render('messages/Edit', [
                'child' => $child,
                'daycare' => $daycare,
                'message' => $message 
            ]);
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageRequest $request, Daycare $daycare, Child $child, Message $message)
    {
        if (Auth::user()->can('act', $daycare)) {
            $message->update($request->all());
         }
 
         return redirect()->route('daycares.children.show', [$daycare, $child, 'tab' => 'messages']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Daycare $daycare, Child $child, Message $message)
    {
        if (Auth::user()->can('act', $daycare)) {
            $message->delete();

            return redirect()->back();
        }

        return back();
    }
}

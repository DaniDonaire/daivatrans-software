<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = Status::all();

        // Si hay una búsqueda
        if ($request->has('search')) {
            $status->where('name', 'like', "%{$request->search}%");
        }

        return view('status.index', compact('status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('status.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Status::create($request->all());

        return redirect()->route('status.index')
                         ->with('success', 'Status created successfully.');
    }

    public function store2(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $status = Status::create($request->all());;

        return response()->json([
            'success' => true,
            'message' => 'Status created successfully.',
            'data' => $status
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {
        return view('status.show', compact('status'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status)
    {
        return view('status.edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Status $status)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $status->update($request->all());

        return redirect()->route('status.index')
                         ->with('success', 'Status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status)
    {
        $status->delete();

        return redirect()->route('status.index')
                         ->with('success', 'Status deleted successfully.');
    }
    
    public function updateColors(Request $request)
    {
        $validatedData = $request->validate([
            'colors.*' => 'required|string|size:7',
            'text_colors.*' => 'required|string|size:7'
        ]);
    
        foreach ($validatedData['colors'] as $id => $color) {
            $status = Status::find($id);
            if ($status) {
                $status->color = $color;
                $status->save();
            }
        }
    
        foreach ($validatedData['text_colors'] as $id => $color) {
            $status = Status::find($id);
            if ($status) {
                $status->text_color = $color;
                $status->save();
            }
        }
    
        return redirect()->route('leads.index')
                         ->with('success', 'Colores actualizados exitosamente.');
    }
}

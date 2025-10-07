<?php

namespace App\Http\Controllers;

use App\Models\ContactMethod;
use Illuminate\Http\Request;

class ContactMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $contactMethods = ContactMethod::query();

        // Búsqueda por nombre
        if ($request->has('search')) {
            $contactMethods->where('name', 'like', "%{$request->search}%");
        }

        $contactMethods = $contactMethods->paginate($request->input('perPage', 10));

        return view('contact_methods.index', compact('contactMethods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contact_methods.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ContactMethod::create($request->all());

        return redirect()->route('contact-methods.index')->with('success', 'Método de contacto creado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactMethod $contactMethod)
    {
        return view('contact_methods.edit', compact('contactMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactMethod $contactMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $contactMethod->update($request->all());

        return redirect()->route('contact-methods.index')->with('success', 'Método de contacto actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactMethod $contactMethod)
    {
        $contactMethod->delete();

        return redirect()->route('contact-methods.index')->with('success', 'Método de contacto eliminado exitosamente.');
    }
}

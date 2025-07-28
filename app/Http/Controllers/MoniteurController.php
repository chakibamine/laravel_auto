<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Moniteur;

class MoniteurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $moniteurs = Moniteur::all();
        return view('moniteurs.index', compact('moniteurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('moniteurs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cin' => 'required|string|max:255',
            'n_permit' => 'required|string|max:255',
            'categorie_permit' => 'required|array|min:1',
            'categorie_permit.*' => 'in:A,B,C,D,EC',
            'n_carte_moniteur' => 'required|string|max:255',
            'categorie_carte_moniteur' => 'required|array|min:1',
            'categorie_carte_moniteur.*' => 'in:A,B,C,D,EC',
        ]);
        $validated['categorie_permit'] = implode(',', $validated['categorie_permit']);
        $validated['categorie_carte_moniteur'] = implode(',', $validated['categorie_carte_moniteur']);
        Moniteur::create($validated);
        return redirect()->route('moniteurs.index')->with('success', 'Moniteur created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $moniteur = Moniteur::findOrFail($id);
        return view('moniteurs.show', compact('moniteur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $moniteur = Moniteur::findOrFail($id);
        return view('moniteurs.edit', compact('moniteur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cin' => 'required|string|max:255',
            'n_permit' => 'required|string|max:255',
            'categorie_permit' => 'required|array|min:1',
            'categorie_permit.*' => 'in:A,B,C,D,EC',
            'n_carte_moniteur' => 'required|string|max:255',
            'categorie_carte_moniteur' => 'required|array|min:1',
            'categorie_carte_moniteur.*' => 'in:A,B,C,D,EC',
        ]);
        $validated['categorie_permit'] = implode(',', $validated['categorie_permit']);
        $validated['categorie_carte_moniteur'] = implode(',', $validated['categorie_carte_moniteur']);
        $moniteur = Moniteur::findOrFail($id);
        $moniteur->update($validated);
        return redirect()->route('moniteurs.index')->with('success', 'Moniteur updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $moniteur = Moniteur::findOrFail($id);
        $moniteur->delete();
        return redirect()->route('moniteurs.index')->with('success', 'Moniteur deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Remainder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RemainderController extends Controller
{
    /**
     * Display a listing of remainders
     */
    public function index(Request $request)
    {
        $query = Remainder::query();

        // Search
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('type', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Sorting
        $sortField = $request->get('sort', 'date');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $remainders = $query->paginate(10);
        $types = Remainder::distinct('type')->pluck('type');

        return view('remainders.index', compact('remainders', 'types'));
    }

    /**
     * Show the form for creating a new remainder
     */
    public function create()
    {
        return view('remainders.create');
    }

    /**
     * Store a newly created remainder
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'date' => 'required|date',
            'type' => 'required|max:50',
            'description' => 'nullable|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('remainders.create')
                ->withErrors($validator)
                ->withInput();
        }

        $remainder = new Remainder($request->all());
        $remainder->save();

        return redirect()
            ->route('remainders.index')
            ->with('success', 'Remainder created successfully.');
    }

    /**
     * Display the specified remainder
     */
    public function show(Remainder $remainder)
    {
        return view('remainders.show', compact('remainder'));
    }

    /**
     * Show the form for editing the specified remainder
     */
    public function edit(Remainder $remainder)
    {
        return view('remainders.edit', compact('remainder'));
    }

    /**
     * Update the specified remainder
     */
    public function update(Request $request, Remainder $remainder)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'date' => 'required|date',
            'type' => 'required|max:50',
            'description' => 'nullable|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('remainders.edit', $remainder)
                ->withErrors($validator)
                ->withInput();
        }

        $remainder->fill($request->all());
        $remainder->save();

        return redirect()
            ->route('remainders.index')
            ->with('success', 'Remainder updated successfully.');
    }

    /**
     * Remove the specified remainder
     */
    public function destroy(Remainder $remainder)
    {
        $remainder->delete();

        return redirect()
            ->route('remainders.index')
            ->with('success', 'Remainder deleted successfully.');
    }
} 
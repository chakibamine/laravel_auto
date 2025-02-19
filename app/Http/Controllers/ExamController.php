<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ExamController extends Controller
{
    /**
     * Display a listing of the exams.
     */
    public function index(): View
    {
        $exams = Exam::with('dossier')->latest('date_exam')->paginate(10);
        return view('exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new exam.
     */
    public function create(): View
    {
        return view('exams.create');
    }

    /**
     * Store a newly created exam in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'date_exam' => 'required|date',
            'type_exam' => 'required|string|max:25',
            'resultat' => 'required|string|max:1',
            'dossier_id' => 'required|exists:dossiers,id',
        ]);

        $validated['date_insertion'] = now();
        $validated['insert_user'] = auth()->user()->name;

        Exam::create($validated);

        return redirect()->route('exams.index')
            ->with('success', 'Exam created successfully.');
    }

    /**
     * Display the specified exam.
     */
    public function show(Exam $exam): View
    {
        return view('exams.show', compact('exam'));
    }

    /**
     * Show the form for editing the specified exam.
     */
    public function edit(Exam $exam): View
    {
        return view('exams.edit', compact('exam'));
    }

    /**
     * Update the specified exam in storage.
     */
    public function update(Request $request, Exam $exam): RedirectResponse
    {
        $validated = $request->validate([
            'date_exam' => 'required|date',
            'type_exam' => 'required|string|max:25',
            'resultat' => 'required|string|max:1',
            'dossier_id' => 'required|exists:dossiers,id',
        ]);

        $exam->update($validated);

        return redirect()->route('exams.index')
            ->with('success', 'Exam updated successfully.');
    }

    /**
     * Remove the specified exam from storage.
     */
    public function destroy(Exam $exam): RedirectResponse
    {
        $exam->delete();

        return redirect()->route('exams.index')
            ->with('success', 'Exam deleted successfully.');
    }
} 
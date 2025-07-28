<?php

namespace App\Http\Controllers;

use App\Models\Dossier;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Exam;
use App\Models\Reg;

class DossierController extends Controller
{
    /**
     * Display a listing of the dossiers.
     */
    public function index()
    {
        $dossiers = Dossier::with('student')->paginate(10);
        return view('dossiers.index', compact('dossiers'));
    }

    /**
     * Show the form for creating a new dossier.
     */
    public function create(Request $request)
    {
        $student = Student::findOrFail($request->student_id);
        return view('dossiers.create', compact('student'));
    }

    /**
     * Store a newly created dossier in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:2',
            'price' => 'required|integer',
            'ref' => 'required|string|max:6',
            'student_id' => 'required|exists:students,id'
        ]);

        $validated['insert_user'] = Auth::user()->name;
        $validated['date_inscription'] = now();
        $validated['status'] = false;
        $validated['resultat'] = false;

        $dossier = Dossier::create($validated);

        return redirect()->route('dossiers.show', $dossier)
            ->with('success', 'Dossier created successfully.');
    }

    /**
     * Display the specified dossier.
     */
    public function show(Dossier $dossier)
    {
        return view('dossiers.show', compact('dossier'));
    }

    /**
     * Show the form for editing the specified dossier.
     */
    public function edit(Dossier $dossier)
    {
        return view('dossiers.edit', compact('dossier'));
    }

    /**
     * Update the specified dossier in storage.
     */
    public function update(Request $request, Dossier $dossier)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:2',
            'price' => 'required|integer',
            'ref' => 'required|string|max:6',
            'status' => 'boolean',
            'resultat' => 'boolean'
        ]);

        $dossier->update($validated);

        return redirect()->route('dossiers.show', $dossier)
            ->with('success', 'Dossier updated successfully.');
    }

    /**
     * Remove the specified dossier from storage.
     */
    public function destroy(Dossier $dossier)
    {
        $dossier->delete();

        return redirect()->route('dossiers.index')
            ->with('success', 'Dossier deleted successfully.');
    }

    public function generateContractPdf($id)
    {
        try {
            $dossier = Dossier::with('student')->findOrFail($id);
            return view('contract.show', compact('dossier'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error displaying contract: ' . $e->getMessage());
        }
    }

    public function generateExamFiche($examId)
    {
        try {
            $exam = Exam::with(['dossier.student'])->findOrFail($examId);
            return view('pdf.exam-fiche', [
                'exam' => $exam,
                'dossier' => $exam->dossier
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Error displaying exam fiche: ' . $e->getMessage());
        }
    }
    public function generateFinFormationFiche($examId)
    {
        try {
            $exam = Exam::with(['dossier.student'])->findOrFail($examId);
            return view('pdf.finformation', [
                'exam' => $exam,
                'dossier' => $exam->dossier
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Error displaying exam fiche: ' . $e->getMessage());
        }
    }

    public function generateInvoice($id)
    {
        $dossier = Dossier::with('student')->findOrFail($id);
        $reglements = Reg::where('dossier_id', $id)->orderBy('date_reg', 'desc')->get();
        $totalPaid = $reglements->sum('price');
        $remaining = $dossier->price - $totalPaid;

        return view('pdf.invoice', [
            'dossier' => $dossier,
            'reglements' => $reglements,
            'totalPaid' => $totalPaid,
            'remaining' => $remaining
        ]);
    }

    public function generateExternalPayment($id)
    {
        try {
            $dossier = Dossier::with('student')->findOrFail($id);
            return view('pdf.external-payment', [
                'dossier' => $dossier
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Error generating external payment receipt: ' . $e->getMessage());
        }
    }

    public function ficheConduit()
    {
        $dossiers = Dossier::with(['student', 'exams', 'courses'])
            ->whereHas('student')
            ->where('status', 1)
            ->get();

        return view('pdf.fiche-conduit', compact('dossiers'));
    }
} 
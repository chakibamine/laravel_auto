<?php

namespace App\Http\Livewire\Components;

use App\Models\Dossier;
use App\Models\Exam;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExamModal extends Component
{
    public $showModal = false;
    public $showConfirmModal = false;
    public $selectedDossier = null;
    public $examToDelete = null;
    public $exam = [
        'date_exam' => '',
        'type_exam' => '',
        'dossier_id' => '',
        'n_serie' => '',
    ];
    public $exams = [];

    protected $listeners = ['showExamModal' => 'show'];

    protected $rules = [
        'exam.date_exam' => 'required|date',
        'exam.type_exam' => 'required|string|max:25',
        'exam.dossier_id' => 'required|exists:dossier,id',
        'exam.n_serie' => 'required_if:exams.*.count,0|string|max:50'
    ];

    public function mount()
    {
        $this->exam['date_exam'] = now()->format('Y-m-d');
    }

    private function determineExamType()
    {
        $examCount = count($this->exams);
        
        switch ($examCount) {
            case 0:
                $this->exam['type_exam'] = 'Theorique';
                break;
                
            case 1:
                if ($this->exams[0]->resultat == '2') {
                    $this->exam['type_exam'] = 'Pratique';
                } elseif ($this->exams[0]->resultat == '0' || $this->exams[0]->resultat == '1') {
                    $this->exam['type_exam'] = 'Theorique';
                }
                break;
                
            case 2:
                // Most recent exam first (due to orderBy desc in loadExams)
                if ($this->exams[0]->resultat == '2' && $this->exams[1]->resultat == '0') {
                    $this->exam['type_exam'] = 'Pratique';
                } elseif ($this->exams[0]->resultat == '1' && $this->exams[1]->resultat == '0') {
                    $this->exam['type_exam'] = 'Theorique';
                } elseif ($this->exams[0]->resultat == '1' && $this->exams[1]->resultat == '2') {
                    $this->exam['type_exam'] = 'Pratique';
                } elseif ($this->exams[0]->resultat == '2' && $this->exams[1]->resultat == '1') {
                    $this->exam['type_exam'] = 'Pratique';
                }
                break;
                
            case 3:
                if ($this->exams[2]->resultat == '0') {
                    $this->exam['type_exam'] = 'Pratique';
                }
                break;
        }
    }

    public function show($dossierId)
    {
        try {
            $this->selectedDossier = Dossier::with('student')->findOrFail($dossierId);
            $this->exam['dossier_id'] = $dossierId;
            $this->loadExams();
            $this->determineExamType();
            $this->showModal = true;
        } catch (\Exception $e) {
            session()->flash('error', 'Error loading exam modal: ' . $e->getMessage());
        }
    }

    public function loadExams()
    {
        if ($this->selectedDossier) {
            $this->exams = Exam::where('dossier_id', $this->selectedDossier->id)
                ->orderBy('date_exam', 'desc')
                ->get();
        }
    }

    public function saveExam()
    {
        try {
            $this->validate();

            // Check if maximum exams reached
            $examCount = Exam::where('dossier_id', $this->exam['dossier_id'])->count();
            if ($examCount >= 3) {
                throw new \Exception('Maximum number of exams (3) reached.');
            }

            $examData = [
                'date_exam' => $this->exam['date_exam'],
                'type_exam' => $this->exam['type_exam'],
                'resultat' => '0', // 0 = En cours, 1 = Inapte, 2 = Apte
                'dossier_id' => $this->exam['dossier_id'],
                'date_insertion' => now(),
                'insert_user' => Auth::user()->name
            ];

            // If this is the first exam
            if ($examCount === 0) {
                // Update dossier with n_serie and date_cloture
                $dossier = Dossier::findOrFail($this->exam['dossier_id']);
                $dossier->update([
                    'n_serie' => $this->exam['n_serie'],
                    'date_cloture' => now()
                ]);
            }

            $newExam = Exam::create($examData);

            if (!$newExam) {
                throw new \Exception('Failed to create exam record');
            }

            session()->flash('success', 'Examen ajouté avec succès.');
            $this->resetExam();
            $this->loadExams();
            $this->emit('examSaved');

        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de l\'ajout de l\'examen: ' . $e->getMessage());
        }
    }

    private function isFullyPaid()
{
    if (!$this->selectedDossier) {
        return false;
    }

    $totalPaid = \App\Models\Reg::where('dossier_id', $this->selectedDossier->id)->sum('prix');
    return floatval($totalPaid) >= floatval($this->selectedDossier->price);
}

private function isLastExam($result)
{
    if (!$this->selectedDossier) {
        return false;
    }

    $allExams = Exam::where('dossier_id', $this->selectedDossier->id)
                    ->orderBy('date_exam', 'asc') // Order by asc to get oldest first
                    ->get();

    $examCount = count($allExams);

    switch ($examCount) {
        case 2:
            // Check if we're trying to update the second exam
            if ($allExams[1]->resultat == '0') {
                if ($allExams[0]->resultat == '1' && $result == '1') {
                    return true;
                }
                if ($allExams[0]->resultat == '2' && $result == '2') {
                    return true;
                }
            }
            break;

        case 3:
            return true;

        default:
            return false;
    }

    return false;
}

public function updateExamResult($examId, $result)
{
    if ($this->isLastExam($result) && !$this->isFullyPaid()) {
        session()->flash('error', 'Le dossier doit être entièrement payé avant de pouvoir entrer le résultat.');
        return;
    }

    $exam = Exam::findOrFail($examId);

    if ($exam->date_exam->isAfter(now())) {
        session()->flash('error', 'Impossible de mettre à jour le résultat pour un examen futur.');
        return;
    }

    $exam->update(['resultat' => $result]);
    session()->flash('success', 'Résultat mis à jour avec succès.');
    $this->loadExams();
    $this->determineExamType();
}

    public function confirmDelete($examId)
    {
        $this->examToDelete = $examId;
        $this->showConfirmModal = true;
    }

    public function cancelDelete()
    {
        $this->showConfirmModal = false;
        $this->examToDelete = null;
    }

    public function deleteExam()
    {
        try {
            if (auth()->user()->role === 'admin' && $this->examToDelete) {
                $exam = Exam::findOrFail($this->examToDelete);
                $exam->delete();
                session()->flash('success', 'Examen supprimé avec succès.');
                $this->loadExams();
                $this->determineExamType();
                $this->cancelDelete();
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showConfirmModal = false;
        $this->examToDelete = null;
        $this->resetExam();
    }

    private function resetExam()
    {
        $examCount = count($this->exams);
        $this->exam = [
            'date_exam' => now()->format('Y-m-d'),
            'type_exam' => $this->exam['type_exam'] ?? '', // Keep the type determined by show()
            'dossier_id' => $this->selectedDossier ? $this->selectedDossier->id : '',
            'n_serie' => '',
        ];
    }

    public function hydrate()
    {
        // This method runs on every request to ensure proper state
        if (!$this->showModal) {
            $this->resetExam();
            $this->showConfirmModal = false;
            $this->examToDelete = null;
        }
    }

    public function render()
    {
        return view('livewire.components.exam-modal');
    }
} 
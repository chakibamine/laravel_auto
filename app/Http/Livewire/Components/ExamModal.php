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
    ];
    public $exams = [];

    protected $listeners = ['showExamModal' => 'show'];

    protected $rules = [
        'exam.date_exam' => 'required|date',
        'exam.type_exam' => 'required|string|max:25',
        'exam.dossier_id' => 'required|exists:dossier,id'
    ];

    public function mount()
    {
        $this->exam['date_exam'] = now()->format('Y-m-d');
    }

    public function show($dossierId)
    {
        try {
            $this->selectedDossier = Dossier::with('student')->findOrFail($dossierId);
            $this->exam['dossier_id'] = $dossierId;
            $this->loadExams();
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

            $newExam = Exam::create([
                'date_exam' => $this->exam['date_exam'],
                'type_exam' => $this->exam['type_exam'],
                'resultat' => '0', // 0 = En cours, 1 = Inapte, 2 = Apte
                'dossier_id' => $this->exam['dossier_id'],
                'date_insertion' => now(),
                'insert_user' => Auth::user()->name
            ]);

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

    public function updateExamResult($examId, $result)
    {
        try {
            $exam = Exam::findOrFail($examId);
            
            // Only allow updating if exam date is today or in the past
            if ($exam->date_exam->isAfter(now())) {
                throw new \Exception('Cannot update result for future exams.');
            }

            $exam->update([
                'resultat' => $result
            ]);

            session()->flash('success', 'Résultat mis à jour avec succès.');
            $this->loadExams();

        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
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
        $this->exam = [
            'date_exam' => now()->format('Y-m-d'),
            'type_exam' => '',
            'dossier_id' => $this->selectedDossier ? $this->selectedDossier->id : '',
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
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

    private function getNextNSerie()
    {        
        $lastDossier = Dossier::where('category', 'B')
            ->whereNotNull('n_serie')
            ->orderBy('n_serie', 'desc')
            ->first();

        $nextNumber = $lastDossier ? intval($lastDossier->n_serie) + 1 : 1;
        
        // If next number is 10 or greater, increment from 10 (10, 11, 12, etc)
        if ($nextNumber >= 10) {
            return (string) $nextNumber;
        }
        
        return (string) $nextNumber;
    }

    private function getQuotaCount()
    {
        return Dossier::where('category', 'B')
            ->whereYear('date_cloture', Carbon::now()->year)
            ->whereMonth('date_cloture', Carbon::now()->month)
            ->count();
    }

    public function show($dossierId)
    {
        try {
            \Log::info('ExamModal show method called with dossier ID: ' . $dossierId);
            
            // Reset any existing state
            $this->resetExam();
            $this->showConfirmModal = false;
            $this->examToDelete = null;
            
            // Find the dossier with student relationship
            $this->selectedDossier = Dossier::with('student')->findOrFail($dossierId);
            \Log::info('Found dossier with student: ' . $this->selectedDossier->id);
            
            // Set the dossier ID
            $this->exam['dossier_id'] = $dossierId;
            
            // Load exams
            $this->loadExams();
            \Log::info('Loaded ' . count($this->exams) . ' exams');
            
            // If this is the first exam and category is B, generate n_serie
            if (count($this->exams) === 0 && $this->selectedDossier->category === 'B') {
                $this->exam['n_serie'] = $this->getNextNSerie();
                \Log::info('Generated n_serie for first exam: ' . $this->exam['n_serie']);
            }
            
            // Determine exam type based on existing exams
            $this->determineExamType();
            \Log::info('Determined exam type: ' . $this->exam['type_exam']);
            
            // Show the modal
            $this->showModal = true;
            \Log::info('Set showModal to true');
            
        } catch (\Exception $e) {
            \Log::error('Error in ExamModal show method: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
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

    private function checkQuota()
    {
        if ($this->selectedDossier && $this->selectedDossier->category === 'B') {
            $currentMonth = Carbon::now()->format('Y-m');
            
            $totalExams = Dossier::where('category', 'B')
                ->whereYear('date_cloture', Carbon::now()->year)
                ->whereMonth('date_cloture', Carbon::now()->month)
                ->count();

            return $totalExams < 12;
        }
        
        return true; // No quota restriction for other categories
    }

    public function saveExam()
    {
        try {
            $this->validate();

            // Check if this is the first exam
            $examCount = Exam::where('dossier_id', $this->exam['dossier_id'])->count();
            
            if ($examCount === 0) {
                // Check quota for category B
                if (!$this->checkQuota()) {
                    session()->flash('error', 'Le quota est plein pour ce mois (12/12).');
                    return;
                }

                // For first exam, update dossier with n_serie and date_cloture
                $dossier = Dossier::findOrFail($this->exam['dossier_id']);
                $dossier->update([
                    'n_serie' => $this->exam['n_serie'],
                    'date_cloture' => now()
                ]);
            }

            $examData = [
                'date_exam' => $this->exam['date_exam'],
                'type_exam' => $this->exam['type_exam'],
                'resultat' => '0', // 0 = En cours, 1 = Inapte, 2 = Apte
                'dossier_id' => $this->exam['dossier_id'],
                'date_insertion' => now(),
                'insert_user' => Auth::user()->name
            ];

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

        $totalPaid = \App\Models\Reg::where('dossier_id', $this->selectedDossier->id)->sum('price');
        return floatval($totalPaid) >= floatval($this->selectedDossier->price);
    }

    private function isLastExam($result)
    {
        if (!$result) {
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

        // If this is the last exam, update dossier status
        if ($this->isLastExam($result)) {
            if ($result == '2') { // APTE
                $this->selectedDossier->update([
                    'status' => 0,
                    'resultat' => 1
                ]);
            } else { // INAPTE
                $this->selectedDossier->update([
                    'status' => 0,
                    'resultat' => 0
                ]);
            }
            // Reload the dossier list if this is the final exam
            $this->emit('refreshComponent');
        }

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
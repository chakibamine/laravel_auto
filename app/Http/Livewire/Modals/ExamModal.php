<?php

namespace App\Http\Livewire\Modals;

use App\Models\Exam;
use App\Models\Dossier;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ExamModal extends Component
{
    public $showModal = false;
    public $selectedDossier = null;
    public $exam = [
        'date_exam' => '',
        'type_exam' => '',
        'resultat' => '0',
        'dossier_id' => '',
    ];
    public $exams;
    public $isMaxExamsReached = false;

    protected $listeners = ['showExamModal' => 'showModal'];

    protected $rules = [
        'exam.date_exam' => 'required|date',
        'exam.type_exam' => 'required|string|max:25',
        'exam.dossier_id' => 'required|exists:dossiers,id',
    ];

    public function showModal(Dossier $dossier)
    {
        $this->selectedDossier = $dossier;
        $this->exam['dossier_id'] = $dossier->id;
        $this->loadExams();
        $this->checkMaxExams();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['exam', 'selectedDossier']);
    }

    public function loadExams()
    {
        $this->exams = Exam::where('dossier_id', $this->selectedDossier->id)
            ->orderBy('date_exam', 'desc')
            ->get();
    }

    public function checkMaxExams()
    {
        $examCount = $this->exams->count();
        $failedExams = $this->exams->where('resultat', '1')->count();
        $passedExams = $this->exams->where('resultat', '2')->count();

        $this->isMaxExamsReached = $examCount >= 3 || 
            ($failedExams >= 2 && $passedExams >= 1) || 
            ($passedExams >= 2);
    }

    public function saveExam()
    {
        $this->validate();

        $this->exam['date_insertion'] = now();
        $this->exam['insert_user'] = Auth::user()->name;
        
        Exam::create($this->exam);

        $this->loadExams();
        $this->checkMaxExams();
        $this->reset(['exam']);

        session()->flash('success', 'Examen ajouté avec succès.');
    }

    public function updateExamResult($examId, $result)
    {
        $exam = Exam::findOrFail($examId);
        $exam->update(['resultat' => $result]);

        $this->loadExams();
        $this->checkMaxExams();
    }

    public function deleteExam($examId)
    {
        if (Auth::user()->role !== 'admin') {
            return;
        }

        $exam = Exam::findOrFail($examId);
        if ($exam->resultat == '0') {
            $exam->delete();
            $this->loadExams();
            $this->checkMaxExams();
        }
    }

    public function render()
    {
        return view('livewire.modals.exam-modal');
    }
} 
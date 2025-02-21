<?php

namespace App\Http\Livewire\Components;

use App\Models\Cour;
use App\Models\Dossier;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AddCourModal extends Component
{
    public $showModal = false;
    public $date_cours;
    public $type;
    public $selectedDossiers = [];
    public $searchTerm = '';

    protected $listeners = ['showAddCourModal' => 'showModal'];

    protected $rules = [
        'date_cours' => 'required|date',
        'type' => 'required|in:Theorique,Pratique',
        'selectedDossiers' => 'required|array|min:1',
        'selectedDossiers.*' => 'exists:dossier,id'
    ];

    protected $messages = [
        'date_cours.required' => 'La date est obligatoire',
        'date_cours.date' => 'La date est invalide',
        'type.required' => 'Le type est obligatoire',
        'type.in' => 'Le type doit être Théorique ou Pratique',
        'selectedDossiers.required' => 'Veuillez sélectionner au moins un dossier',
        'selectedDossiers.array' => 'Format de sélection invalide',
        'selectedDossiers.min' => 'Veuillez sélectionner au moins un dossier',
        'selectedDossiers.*.exists' => 'Un des dossiers sélectionnés n\'existe pas'
    ];

    public function showModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['date_cours', 'type', 'selectedDossiers', 'searchTerm']);
        $this->resetValidation();
    }

    public function saveCours()
    {
        $this->validate();

        try {
            foreach ($this->selectedDossiers as $dossierId) {
                Cour::create([
                    'date_cours' => $this->date_cours,
                    'type_cours' => $this->type,
                    'dossier_id' => $dossierId,
                    'date_insertion' => now(),
                    'insert_user' => Auth::user()->name
                ]);
            }

            session()->flash('success', 'Cours ajoutés avec succès');
            $this->emit('coursAdded');
            $this->closeModal();

        } catch (\Exception $e) {
            session()->flash('error', 'Une erreur est survenue lors de l\'ajout des cours: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $dossiers = Dossier::with(['student', 'courses'])
            ->where('category', 'B')
            ->where('status', 1)
            ->when($this->searchTerm, function($query) {
                $query->whereHas('student', function($query) {
                    $query->where('firstname', 'like', '%'.$this->searchTerm.'%')
                        ->orWhere('lastname', 'like', '%'.$this->searchTerm.'%')
                        ->orWhere('cin', 'like', '%'.$this->searchTerm.'%');
                })
                ->orWhere('ref', 'like', '%'.$this->searchTerm.'%');
            })
            ->orderBy('date_inscription', 'desc')
            ->get();

        return view('livewire.components.add-cour-modal', [
            'dossiers' => $dossiers
        ]);
    }
} 
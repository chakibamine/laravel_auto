<?php

namespace App\Http\Livewire;

use App\Models\Cour;
use App\Models\Dossier;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class CourList extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $showModal = false;
    public $selectedDossier = null;
    public $cour = [
        'date_cours' => '',
        'type_cours' => '',
        'dossier_id' => '',
    ];

    protected $listeners = ['coursAdded' => '$refresh'];
    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'cour.date_cours' => 'required|date',
        'cour.type_cours' => 'required|in:Theorique,Pratique',
        'cour.dossier_id' => 'required|exists:dossier,id'
    ];

    protected $messages = [
        'cour.date_cours.required' => 'La date est obligatoire',
        'cour.date_cours.date' => 'La date est invalide',
        'cour.type_cours.required' => 'Le type est obligatoire',
        'cour.type_cours.in' => 'Le type doit être Théorique ou Pratique',
        'cour.dossier_id.required' => 'Le dossier est obligatoire',
        'cour.dossier_id.exists' => 'Le dossier sélectionné n\'existe pas',
    ];

    public function mount()
    {
        $this->cour['date_cours'] = now()->format('Y-m-d');
    }

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function openCourModal($dossierId)
    {
        try {
            $dossier = Dossier::with('student')->findOrFail($dossierId);
            
            // Only allow adding courses to dossiers with category B
            if ($dossier->category !== 'B') {
                session()->flash('error', 'Vous ne pouvez ajouter des cours qu\'aux dossiers de permis B.');
                return;
            }
            
            $this->selectedDossier = $dossier;
            $this->cour['dossier_id'] = $dossierId;
            $this->showModal = true;
        } catch (\Exception $e) {
            session()->flash('error', 'Error loading course modal: ' . $e->getMessage());
        }
    }

    public function saveCour()
    {
        try {
            $this->validate();

            $newCour = Cour::create([
                'date_cours' => $this->cour['date_cours'],
                'type_cours' => $this->cour['type_cours'],
                'dossier_id' => $this->cour['dossier_id'],
                'date_insertion' => now(),
                'insert_user' => Auth::user()->name
            ]);

            if (!$newCour) {
                throw new \Exception('Failed to create course record');
            }

            session()->flash('success', 'Cours ajouté avec succès.');
            $this->resetCour();
            $this->emit('coursAdded');
            $this->closeModal();

        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de l\'ajout du cours: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedDossier = null;
        $this->resetCour();
    }

    private function resetCour()
    {
        $this->cour = [
            'date_cours' => now()->format('Y-m-d'),
            'type_cours' => '',
            'dossier_id' => $this->selectedDossier ? $this->selectedDossier->id : '',
        ];
    }

    public function render()
    {
        $dossiers = Dossier::with(['student', 'courses'])
            ->where('status', 1)
            ->where('category', 'B')
            ->when($this->searchTerm, function($query) {
                $query->whereHas('student', function($query) {
                    $query->where('firstname', 'like', '%'.$this->searchTerm.'%')
                        ->orWhere('lastname', 'like', '%'.$this->searchTerm.'%')
                        ->orWhere('cin', 'like', '%'.$this->searchTerm.'%');
                })
                ->orWhere('ref', 'like', '%'.$this->searchTerm.'%');
            })
            ->orderBy('date_inscription', 'desc')
            ->paginate(10);

        return view('livewire.cour-list', [
            'dossiers' => $dossiers
        ]);
    }
} 
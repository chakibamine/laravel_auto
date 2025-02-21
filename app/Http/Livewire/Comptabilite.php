<?php

namespace App\Http\Livewire;

use App\Models\Entrer;
use App\Models\Sortie;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Comptabilite extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $dateFilter = '';
    public $showEntrerModal = false;
    public $showSortieModal = false;
    public $selectedType = 'entrees'; // or 'sorties'
    public $showConfirmModal = false;
    public $itemToDelete = null;
    public $deleteType = null;
    
    // Entrer form
    public $entrer = [
        'date_entrer' => '',
        'motif' => '',
        'montant' => '',
    ];

    // Sortie form
    public $sortie = [
        'date_sortie' => '',
        'motif' => '',
        'montant' => '',
    ];

    protected $rules = [
        'entrer.date_entrer' => 'required|date',
        'entrer.motif' => 'required|string|max:70',
        'entrer.montant' => 'required|numeric|min:0',
        'sortie.date_sortie' => 'required|date',
        'sortie.motif' => 'required|string|max:70',
        'sortie.montant' => 'required|numeric|min:0',
    ];

    protected $messages = [
        'entrer.date_entrer.required' => 'La date est obligatoire',
        'entrer.motif.required' => 'Le motif est obligatoire',
        'entrer.montant.required' => 'Le montant est obligatoire',
        'entrer.montant.numeric' => 'Le montant doit être un nombre',
        'sortie.date_sortie.required' => 'La date est obligatoire',
        'sortie.motif.required' => 'Le motif est obligatoire',
        'sortie.montant.required' => 'Le montant est obligatoire',
        'sortie.montant.numeric' => 'Le montant doit être un nombre',
    ];

    protected $listeners = [
        'confirmed' => 'handleConfirmed',
        'cancelled' => 'handleCancelled'
    ];

    public function mount()
    {
        $this->entrer['date_entrer'] = now()->format('Y-m-d');
        $this->sortie['date_sortie'] = now()->format('Y-m-d');
    }

    public function showEntrerForm()
    {
        $this->resetValidation();
        $this->entrer = [
            'date_entrer' => now()->format('Y-m-d'),
            'motif' => '',
            'montant' => '',
        ];
        $this->showEntrerModal = true;
    }

    public function showSortieForm()
    {
        $this->resetValidation();
        $this->sortie = [
            'date_sortie' => now()->format('Y-m-d'),
            'motif' => '',
            'montant' => '',
        ];
        $this->showSortieModal = true;
    }

    public function saveEntrer()
    {
        $this->validate([
            'entrer.date_entrer' => 'required|date',
            'entrer.motif' => 'required|string|max:70',
            'entrer.montant' => 'required|numeric|min:0',
        ]);

        try {
            Entrer::create([
                'date_entrer' => $this->entrer['date_entrer'],
                'motif' => $this->entrer['motif'],
                'montant' => $this->entrer['montant'],
                'date_entry' => now(),
            ]);

            session()->flash('success', 'Entrée ajoutée avec succès');
            $this->showEntrerModal = false;
            $this->reset('entrer');
            $this->emit('entrySaved');

        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de l\'ajout de l\'entrée: ' . $e->getMessage());
        }
    }

    public function saveSortie()
    {
        $this->validate([
            'sortie.date_sortie' => 'required|date',
            'sortie.motif' => 'required|string|max:70',
            'sortie.montant' => 'required|numeric|min:0',
        ]);

        try {
            Sortie::create([
                'date_sortie' => $this->sortie['date_sortie'],
                'motif' => $this->sortie['motif'],
                'montant' => $this->sortie['montant'],
                'date_entry' => now(),
            ]);

            session()->flash('success', 'Sortie ajoutée avec succès');
            $this->showSortieModal = false;
            $this->reset('sortie');
            $this->emit('entrySaved');

        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de l\'ajout de la sortie: ' . $e->getMessage());
        }
    }

    public function confirmDelete($id, $type)
    {
        $this->itemToDelete = $id;
        $this->deleteType = $type;
        $message = $type === 'sortie' ? 'cette sortie' : 'cette entrée';
        $this->emit('confirm', [
            'id' => $id,
            'type' => $type,
            'message' => "Êtes-vous sûr de vouloir supprimer {$message} ?"
        ]);
    }

    public function handleConfirmed($data)
    {
        try {
            if ($this->deleteType === 'sortie') {
                $sortie = Sortie::findOrFail($this->itemToDelete);
                $sortie->delete();
                session()->flash('success', 'Sortie supprimée avec succès');
            } else {
                $entree = Entrer::findOrFail($this->itemToDelete);
                $entree->delete();
                session()->flash('success', 'Entrée supprimée avec succès');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }

        $this->itemToDelete = null;
        $this->deleteType = null;
    }

    public function handleCancelled()
    {
        $this->itemToDelete = null;
        $this->deleteType = null;
    }

    public function deleteEntrer($id)
    {
        try {
            Entrer::findOrFail($id)->delete();
            session()->flash('success', 'Entrée supprimée avec succès');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la suppression de l\'entrée');
        }
    }

    public function deleteSortie($id)
    {
        try {
            $sortie = Sortie::findOrFail($id);
            $sortie->delete();
            session()->flash('success', 'Sortie supprimée avec succès');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la suppression de la sortie');
        }
    }

    public function closeModal()
    {
        $this->showEntrerModal = false;
        $this->showSortieModal = false;
        $this->resetValidation();
        $this->reset(['entrer', 'sortie']);
    }

    public function toggleType($type)
    {
        $this->selectedType = $type;
        $this->resetPage();
    }

    public function getTotalEntreesProperty()
    {
        return Entrer::when($this->dateFilter, function($query) {
            return $query->whereDate('date_entrer', $this->dateFilter);
        })->sum('montant');
    }

    public function getTotalSortiesProperty()
    {
        return Sortie::when($this->dateFilter, function($query) {
            return $query->whereDate('date_sortie', $this->dateFilter);
        })->sum('montant');
    }

    public function getBalanceProperty()
    {
        return $this->totalEntrees - $this->totalSorties;
    }

    public function render()
    {
        $entrees = Entrer::when($this->searchTerm, function($query) {
                $query->where('motif', 'like', '%'.$this->searchTerm.'%')
                    ->orWhere('montant', 'like', '%'.$this->searchTerm.'%');
            })
            ->when($this->dateFilter, function($query) {
                $query->whereDate('date_entrer', $this->dateFilter);
            })
            ->orderBy('date_entrer', 'desc')
            ->paginate(10);

        $sorties = Sortie::when($this->searchTerm, function($query) {
                $query->where('motif', 'like', '%'.$this->searchTerm.'%')
                    ->orWhere('montant', 'like', '%'.$this->searchTerm.'%');
            })
            ->when($this->dateFilter, function($query) {
                $query->whereDate('date_sortie', $this->dateFilter);
            })
            ->orderBy('date_sortie', 'desc')
            ->paginate(10);

        return view('livewire.comptabilite', [
            'entrees' => $entrees,
            'sorties' => $sorties,
        ]);
    }
} 
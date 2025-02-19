<?php

namespace App\Http\Livewire;

use App\Models\Dossier;
use App\Models\Reg;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class DossierList extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $sortField = 'id';
    public $sortDirection = 'desc';
    protected $paginationTheme = 'bootstrap';
    public $showModal = false;
    public $selectedDossier = null;
    public $isLuiMeme = false;
    public $totalPaid = 0;
    public $remaining = 0;
    public $showPaymentModal = false;
    public $reg = [
        'date_reg' => '',
        'prix' => '',
        'motif' => '',
        'nom_du_payeur' => '',
    ];

    protected $rules = [
        'reg.date_reg' => 'required|date',
        'reg.prix' => 'required|numeric|min:1',
        'reg.motif' => 'required|string|max:50',
        'reg.nom_du_payeur' => 'required|string|max:75',
        'reg.dossier_id' => 'required|exists:dossier,id'
    ];

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'closePaymentModal' => 'closePaymentModal'
    ];

    public function mount()
    {
        $this->reg['date_reg'] = now()->format('Y-m-d');
    }

    public function updatedIsLuiMeme()
    {
        if ($this->isLuiMeme && $this->selectedDossier) {
            $this->reg['nom_du_payeur'] = $this->selectedDossier->student->lastname . ' ' . $this->selectedDossier->student->firstname;
        } else {
            $this->reg['nom_du_payeur'] = '';
        }
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatedSearchTerm()
    {
        $this->resetPage();
    }

    public function openPaymentModal($dossierId)
    {
        $this->selectedDossier = Dossier::with('student')->findOrFail($dossierId);
        $this->calculateTotals();
        
        // Only show modal if there's remaining amount to pay
        if ($this->remaining > 0) {
            $this->showPaymentModal = true;
            $this->reg['dossier_id'] = $dossierId;
        } else {
            session()->flash('info', 'Ce dossier est déjà entièrement payé.');
        }
    }

    public function calculateTotals()
    {
        if ($this->selectedDossier) {
            $this->totalPaid = Reg::where('dossier_id', $this->selectedDossier->id)->sum('prix');
            $this->remaining = $this->selectedDossier->price - $this->totalPaid;
        }
    }

    public function saveReg()
    {
        try {
            $this->validate();

            // Debug log
            \Log::info('Attempting to save registration with data:', $this->reg);

            // Convert date to proper format
            $date_reg = \Carbon\Carbon::parse($this->reg['date_reg'])->format('Y-m-d H:i:s');

            // Create the registration with properly quoted values
            $newReg = Reg::create([
                'date_reg' => $date_reg,
                'prix' => floatval($this->reg['prix']),
                'motif' => $this->reg['motif'],
                'nom_du_payeur' => $this->reg['nom_du_payeur'],
                'dossier_id' => intval($this->reg['dossier_id']),
                'date_insertion' => now(),
                'insert_user' => Auth::user()->name
            ]);
            
            if (!$newReg) {
                throw new \Exception('Failed to create registration record');
            }

            \Log::info('Registration saved successfully with ID: ' . $newReg->id);

            // Recalculate totals
            $this->calculateTotals();
            
            // Reset only the form fields, not the entire reg array
            $this->reg['prix'] = '';
            $this->reg['motif'] = '';
            if (!$this->isLuiMeme) {
                $this->reg['nom_du_payeur'] = '';
            }
            
            session()->flash('success', 'Paiement ajouté avec succès.');
            
            // Don't close modal, just emit refresh event
            $this->emit('refreshComponent');
        } catch (\Exception $e) {
            \Log::error('Error saving registration: ' . $e->getMessage());
            session()->flash('error', 'Erreur lors de l\'ajout du paiement: ' . $e->getMessage());
        }
    }

    public function deleteReg($regId)
    {
        try {
            if (auth()->user()->role === 'admin') {
                $reg = Reg::findOrFail($regId);
                $reg->delete();
                $this->calculateTotals();
                session()->flash('success', 'Paiement supprimé avec succès.');
                $this->emit('refreshComponent');
            }
        } catch (\Exception $e) {
            \Log::error('Error deleting registration: ' . $e->getMessage());
            session()->flash('error', 'Erreur lors de la suppression du paiement: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetReg();
    }

    private function resetReg()
    {
        $this->reset(['reg', 'isLuiMeme']);
        $this->reg['date_reg'] = now()->format('Y-m-d');
        if ($this->selectedDossier) {
            $this->reg['dossier_id'] = $this->selectedDossier->id;
        }
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
        $this->selectedDossier = null;
    }

    public function render()
    {
        $dossiers = Dossier::with('student')
            ->where('status', 0)
            ->when($this->searchTerm, function($query) {
                $query->whereHas('student', function($query) {
                    $query->where('firstname', 'like', '%'.$this->searchTerm.'%')
                        ->orWhere('lastname', 'like', '%'.$this->searchTerm.'%')
                        ->orWhere('cin', 'like', '%'.$this->searchTerm.'%');
                })
                ->orWhere('ref', 'like', '%'.$this->searchTerm.'%')
                ->orWhere('category', 'like', '%'.$this->searchTerm.'%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $registrations = $this->selectedDossier ? 
            Reg::where('dossier_id', $this->selectedDossier->id)
                ->orderBy('date_reg', 'desc')
                ->get() : 
            collect();

        return view('livewire.dossier-list', [
            'dossiers' => $dossiers,
            'registrations' => $registrations
        ]);
    }
} 
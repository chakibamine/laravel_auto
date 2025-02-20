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
    public $showEditModal = false;
    public $editDossier = [
        'category' => '',
        'price' => '',
        'ref' => ''
    ];
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

    protected $editRules = [
        'editDossier.category' => 'required|string|max:2',
        'editDossier.price' => 'required|numeric|min:1',
        'editDossier.ref' => 'required|string|max:6'
    ];

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'closePaymentModal' => 'closePaymentModal',
        'confirmed' => 'handleConfirmed',
        'cancelled' => 'handleCancelled'
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
        try {
            \Log::info('Opening payment modal for dossier: ' . $dossierId);
            $this->selectedDossier = Dossier::with('student')->findOrFail($dossierId);
            $this->reg['dossier_id'] = $dossierId;
            $this->calculateTotals();
            $this->showPaymentModal = true;
        } catch (\Exception $e) {
            \Log::error('Error in openPaymentModal: ' . $e->getMessage());
            session()->flash('error', 'Error loading payment modal: ' . $e->getMessage());
        }
    }

    public function calculateTotals()
    {
        if ($this->selectedDossier) {
            try {
                $this->totalPaid = Reg::where('dossier_id', $this->selectedDossier->id)->sum('prix');
                $this->remaining = floatval($this->selectedDossier->price) - floatval($this->totalPaid);
                \Log::info('Calculated totals in calculateTotals:', [
                    'dossier_id' => $this->selectedDossier->id,
                    'price' => $this->selectedDossier->price,
                    'totalPaid' => $this->totalPaid,
                    'remaining' => $this->remaining
                ]);
            } catch (\Exception $e) {
                \Log::error('Error calculating totals: ' . $e->getMessage());
            }
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
        $this->emit('confirm', [
            'action' => 'deleteReg',
            'id' => $regId
        ]);
    }

    public function deleteDossier($dossierId)
    {
        $this->emit('confirm', [
            'action' => 'deleteDossier',
            'id' => $dossierId
        ]);
    }

    public function handleConfirmed($data)
    {
        if ($data['action'] === 'deleteReg') {
            $this->performDeleteReg($data['id']);
        } elseif ($data['action'] === 'deleteDossier') {
            $this->performDeleteDossier($data['id']);
        }
    }

    public function handleCancelled()
    {
        // Handle cancel if needed
    }

    private function performDeleteReg($regId)
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

    private function performDeleteDossier($dossierId)
    {
        try {
            if (auth()->user()->role === 'admin') {
                $dossier = Dossier::findOrFail($dossierId);
                $dossier->delete();
                session()->flash('success', 'Dossier supprimé avec succès.');
                $this->emit('refreshComponent');
            }
        } catch (\Exception $e) {
            \Log::error('Error deleting dossier: ' . $e->getMessage());
            session()->flash('error', 'Erreur lors de la suppression du dossier: ' . $e->getMessage());
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

    public function openEditModal($dossierId)
    {
        try {
            $dossier = Dossier::findOrFail($dossierId);
            $this->selectedDossier = $dossier;
            $this->editDossier = [
                'category' => $dossier->category,
                'price' => $dossier->price,
                'ref' => $dossier->ref
            ];
            $this->showEditModal = true;
        } catch (\Exception $e) {
            session()->flash('error', 'Error loading dossier: ' . $e->getMessage());
        }
    }

    public function updateDossier()
    {
        try {
            $this->validate($this->editRules);

            $this->selectedDossier->update([
                'category' => $this->editDossier['category'],
                'price' => $this->editDossier['price'],
                'ref' => $this->editDossier['ref']
            ]);

            session()->flash('success', 'Dossier mis à jour avec succès.');
            $this->closeEditModal();
            $this->emit('refreshComponent');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la mise à jour du dossier: ' . $e->getMessage());
        }
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->selectedDossier = null;
        $this->editDossier = [
            'category' => '',
            'price' => '',
            'ref' => ''
        ];
        $this->resetValidation();
    }

    public function render()
    {
        $dossiers = Dossier::with('student')
            ->where('status', 1)
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
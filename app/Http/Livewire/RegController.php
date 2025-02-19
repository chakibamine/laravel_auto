<?php

namespace App\Http\Livewire;

use App\Models\Reg;
use App\Models\Dossier;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class RegController extends Component
{
    public $reg = [
        'date_reg' => '',
        'price' => '',
        'motif' => '',
        'nom_du_payeur' => '',
        'dossier_id' => ''
    ];

    public $showModal = false;
    public $dossier = null;
    public $student = null;
    public $totalPaid = 0;
    public $remaining = 0;
    public $isLuiMeme = false;

    protected $rules = [
        'reg.date_reg' => 'required|date',
        'reg.price' => 'required|integer',
        'reg.motif' => 'required|string|max:50',
        'reg.nom_du_payeur' => 'required|string|max:75',
        'reg.dossier_id' => 'required|exists:dossier,id'
    ];

    protected $listeners = ['showPaymentModal'];

    public function mount()
    {
        $this->reg['date_reg'] = now()->format('Y-m-d');
    }

    public function showPaymentModal($dossierId)
    {
        try {
            $this->dossier = Dossier::with('student')->findOrFail($dossierId);
            if (!$this->dossier->student) {
                session()->flash('error', 'Student not found for this dossier.');
                return;
            }
            
            $this->student = $this->dossier->student;
            $this->reg['dossier_id'] = $this->dossier->id;
            $this->reg['date_reg'] = now()->format('Y-m-d');
            $this->calculateTotals();
            $this->showModal = true;
        } catch (\Exception $e) {
            session()->flash('error', 'Error loading dossier: ' . $e->getMessage());
        }
    }

    public function calculateTotals()
    {
        if ($this->dossier) {
            $this->totalPaid = Reg::where('dossier_id', $this->dossier->id)->sum('price');
            $this->remaining = $this->dossier->price - $this->totalPaid;
        }
    }

    public function updatedIsLuiMeme()
    {
        if ($this->isLuiMeme && $this->student) {
            $this->reg['nom_du_payeur'] = $this->student->lastname . ' ' . $this->student->firstname;
        } else {
            $this->reg['nom_du_payeur'] = '';
        }
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation();
        $this->reset(['reg', 'isLuiMeme', 'dossier', 'student', 'totalPaid', 'remaining']);
        $this->reg['date_reg'] = now()->format('Y-m-d');
    }

    public function saveReg()
    {
        $this->validate();

        $reg = new Reg($this->reg);
        $reg->date_insertion = now();
        $reg->insert_user = Auth::user()->name;
        $reg->save();

        // Handle additional logic for specific motifs
        if ($this->reg['motif'] === 'Free dossier') {
            // Add your sortie logic here
        }

        $this->calculateTotals();
        $this->closeModal();
        $this->emit('regSaved');
    }

    public function render()
    {
        return view('livewire.reg-controller', [
            'registrations' => $this->dossier ? Reg::where('dossier_id', $this->dossier->id)
                                ->orderBy('date_reg', 'desc')
                                ->get() : collect()
        ]);
    }
} 

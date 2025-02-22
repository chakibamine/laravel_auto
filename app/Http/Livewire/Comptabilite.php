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
    public $searchTerm = '';
    public $dateFilter = '';
    public $showEntrerModal = false;
    public $showSortieModal = false;
    public $selectedType = 'entrees'; // or 'sorties'
    public $showConfirmModal = false;
    public $itemToDelete = null;
    public $deleteType = null;
    public $currentMonth;
    public $currentYear;
    public $selectedMonth;
    
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
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->selectedMonth = now()->format('Y-m');
        $this->entrer['date_entrer'] = now()->format('Y-m-d');
        $this->sortie['date_sortie'] = now()->format('Y-m-d');
    }

    public function updatedSelectedMonth($value)
    {
        if ($value) {
            $date = Carbon::createFromFormat('Y-m', $value);
            $this->currentMonth = $date->month;
            $this->currentYear = $date->year;
        }
    }

    public function resetToCurrentMonth()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->selectedMonth = now()->format('Y-m');
    }

    public function getCurrentMonthNameProperty()
    {
        return Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->format('F Y');
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
    }

    public function getTotalEntreesProperty()
    {
        return Entrer::whereYear('date_entrer', $this->currentYear)
            ->whereMonth('date_entrer', $this->currentMonth)
            ->when($this->searchTerm, function($query) {
                $query->where('motif', 'like', '%'.$this->searchTerm.'%')
                    ->orWhere('montant', 'like', '%'.$this->searchTerm.'%');
            })
            ->sum('montant');
    }

    public function getTotalSortiesProperty()
    {
        return Sortie::whereYear('date_sortie', $this->currentYear)
            ->whereMonth('date_sortie', $this->currentMonth)
            ->when($this->searchTerm, function($query) {
                $query->where('motif', 'like', '%'.$this->searchTerm.'%')
                    ->orWhere('montant', 'like', '%'.$this->searchTerm.'%');
            })
            ->sum('montant');
    }

    public function getBalanceProperty()
    {
        return $this->totalEntrees - $this->totalSorties;
    }

    public function openMonthlyReport()
    {
        // Get year and month from selectedMonth
        $date = Carbon::createFromFormat('Y-m', $this->selectedMonth);
        $year = $date->year;
        $month = $date->month;

        // Open report in new tab
        $this->dispatchBrowserEvent('open-report', [
            'url' => route('comptabilite.report', ['year' => $year, 'month' => $month])
        ]);
    }

    public function getMonthlyReportData()
    {
        $startDate = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1);
        $endDate = $startDate->copy()->endOfMonth();
        $days = [];

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $currentDate = $date->format('Y-m-d');
            
            $entrees = Entrer::whereDate('date_entrer', $currentDate)
                ->orderBy('date_entrer')
                ->get();
                
            $sorties = Sortie::whereDate('date_sortie', $currentDate)
                ->orderBy('date_sortie')
                ->get();

            if ($entrees->isEmpty() && $sorties->isEmpty()) {
                $days[$currentDate] = [
                    'date' => $date->format('d/m/Y'),
                    'entries' => [],
                    'exits' => [],
                    'total_entries' => 0,
                    'total_exits' => 0,
                    'balance' => 0
                ];
                continue;
            }

            $maxCount = max($entrees->count(), $sorties->count());
            $entries = [];
            $exits = [];

            for ($i = 0; $i < $maxCount; $i++) {
                $entry = $entrees->get($i);
                $exit = $sorties->get($i);

                $entries[] = $entry ? [
                    'montant' => $entry->montant,
                    'motif' => $entry->motif
                ] : null;

                $exits[] = $exit ? [
                    'montant' => $exit->montant,
                    'motif' => $exit->motif
                ] : null;
            }

            $totalEntries = $entrees->sum('montant');
            $totalExits = $sorties->sum('montant');

            $days[$currentDate] = [
                'date' => $date->format('d/m/Y'),
                'entries' => $entries,
                'exits' => $exits,
                'total_entries' => $totalEntries,
                'total_exits' => $totalExits,
                'balance' => $totalEntries - $totalExits
            ];
        }

        return [
            'days' => $days,
            'total_entries' => collect($days)->sum('total_entries'),
            'total_exits' => collect($days)->sum('total_exits'),
            'total_balance' => collect($days)->sum('balance')
        ];
    }

    public function render()
    {
        $entrees = Entrer::whereYear('date_entrer', $this->currentYear)
            ->whereMonth('date_entrer', $this->currentMonth)
            ->when($this->searchTerm, function($query) {
                $query->where('motif', 'like', '%'.$this->searchTerm.'%')
                    ->orWhere('montant', 'like', '%'.$this->searchTerm.'%');
            })
            ->when($this->dateFilter, function($query) {
                $query->whereDate('date_entrer', $this->dateFilter);
            })
            ->orderBy('date_entrer', 'desc')
            ->get();

        $sorties = Sortie::whereYear('date_sortie', $this->currentYear)
            ->whereMonth('date_sortie', $this->currentMonth)
            ->when($this->searchTerm, function($query) {
                $query->where('motif', 'like', '%'.$this->searchTerm.'%')
                    ->orWhere('montant', 'like', '%'.$this->searchTerm.'%');
            })
            ->when($this->dateFilter, function($query) {
                $query->whereDate('date_sortie', $this->dateFilter);
            })
            ->orderBy('date_sortie', 'desc')
            ->get();

        return view('livewire.comptabilite', [
            'entrees' => $entrees,
            'sorties' => $sorties,
        ]);
    }
} 
<?php

namespace App\Http\Livewire;

use App\Models\Dossier;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Cloture extends Component
{
    use WithPagination;

    public $selectedMonth;
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->selectedMonth = Carbon::now()->format('Y-m');
    }

    public function updatedSelectedMonth()
    {
        $this->resetPage();
    }

    public function getDossiersProperty()
    {
        if (!$this->selectedMonth) {
            return collect();
        }

        $date = Carbon::createFromFormat('Y-m', $this->selectedMonth);

        return Dossier::with(['student', 'exams'])
            ->where('category', 'B')
            ->whereYear('date_cloture', $date->year)
            ->whereMonth('date_cloture', $date->month)
            ->orderBy('n_serie', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.cloture', [
            'dossiers' => $this->dossiers
        ]);
    }
} 
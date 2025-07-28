<?php

namespace App\Http\Livewire;

use App\Models\Dossier;
use App\Models\Car;
use App\Models\Moniteur;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Cloture extends Component
{
    use WithPagination;

    public $selectedMonth;
    public $selectedCar = '';
    public $selectedMoniteur = '';
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

        $query = Dossier::with(['student', 'exams'])
            ->where('category', 'B')
            ->whereYear('date_cloture', $date->year)
            ->whereMonth('date_cloture', $date->month);

        if ($this->selectedCar) {
            $query->where('car_matricule', $this->selectedCar);
        }
        if ($this->selectedMoniteur) {
            $query->where('carte_moniteur', $this->selectedMoniteur);
        }

        return $query->orderBy('n_serie', 'asc')->get();
    }

    public function render()
    {
        $cars = Car::all();
        $moniteurs = Moniteur::all();
        return view('livewire.cloture', [
            'dossiers' => $this->dossiers,
            'cars' => $cars,
            'moniteurs' => $moniteurs,
        ]);
    }
} 
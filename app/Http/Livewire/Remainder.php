<?php

namespace App\Http\Livewire;

use App\Models\Remainder as RemainderModel;
use Livewire\Component;
use Livewire\WithPagination;

class Remainder extends Component
{
    use WithPagination;

    public $remainder;
    public $searchTerm = '';
    public $sortField = 'date';
    public $sortDirection = 'desc';
    public $showModal = false;
    public $showDeleteModal = false;
    public $showSavedAlert = false;
    public $editMode = false;
    public $remainderIdBeingDeleted = null;
    public $filters = [
        'type' => ''
    ];

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'searchTerm' => ['except' => ''],
        'sortField' => ['except' => 'date'],
        'sortDirection' => ['except' => 'desc'],
        'filters'
    ];

    protected $listeners = ['refresh' => '$refresh'];

    protected function rules()
    {
        return [
            'remainder.name' => 'required|string|max:100',
            'remainder.date' => 'required|date',
            'remainder.type' => 'required|string|max:50',
            'remainder.description' => 'nullable|string|max:1000',
        ];
    }

    public function mount()
    {
        $this->remainder = new RemainderModel();
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

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['remainder']);
        $this->remainder = new RemainderModel();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $this->remainder = RemainderModel::findOrFail($id);
        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();
        $this->remainder->save();
        $this->showSavedAlert = true;
        $this->showModal = false;
        $this->reset(['remainder']);
        $this->remainder = new RemainderModel();
        $this->emit('refresh');
    }

    public function confirmDelete($id)
    {
        $this->remainderIdBeingDeleted = $id;
        $this->showDeleteModal = true;
    }

    public function deleteRemainder()
    {
        $remainder = RemainderModel::findOrFail($this->remainderIdBeingDeleted);
        $remainder->delete();
        $this->showDeleteModal = false;
        $this->showSavedAlert = true;
        $this->emit('refresh');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation();
        $this->reset(['remainder']);
        $this->editMode = false;
    }

    public function resetFilters()
    {
        $this->reset('searchTerm', 'filters', 'sortField', 'sortDirection');
    }

    public function hydrate()
    {
        if (!$this->remainder) {
            $this->remainder = new RemainderModel();
        }
    }

    public function render()
    {
        $remainders = RemainderModel::query()
            ->when($this->searchTerm, function($query) {
                $query->where(function($query) {
                    $query->where('name', 'like', '%'.$this->searchTerm.'%')
                        ->orWhere('type', 'like', '%'.$this->searchTerm.'%')
                        ->orWhere('description', 'like', '%'.$this->searchTerm.'%');
                });
            })
            ->when(isset($this->filters['type']) && $this->filters['type'], function($query) {
                $query->where('type', $this->filters['type']);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $types = RemainderModel::distinct('type')->pluck('type')->filter();

        return view('livewire.remainder', [
            'remainders' => $remainders,
            'types' => $types
        ]);
    }
} 
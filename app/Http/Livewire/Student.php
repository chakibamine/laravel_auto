<?php

namespace App\Http\Livewire;

use App\Models\Student as StudentModel;
use App\Models\Dossier;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Student extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $student;
    public $photo;
    public $searchTerm = '';
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $showModal = false;
    public $showDeleteModal = false;
    public $showSavedAlert = false;
    public $showDemoNotification = false;
    public $editMode = false;
    public $studentIdBeingDeleted = null;
    public $filters = [
        'gender' => '',
        'city' => ''
    ];
    public $date_birth;
    public $showDossierModal = false;
    public $dossier = [
        'category' => '',
        'price' => '',
        'ref' => '',
        'student_id' => null
    ];

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'searchTerm' => ['except' => ''],
        'sortField' => ['except' => 'id'],
        'sortDirection' => ['except' => 'desc'],
        'filters'
    ];

    protected $listeners = ['refresh' => '$refresh'];

    protected function rules()
    {
        return [
            'student.firstname' => 'required|string|max:50',
            'student.lastname' => 'required|string|max:50',
            'student.gender' => ['required', Rule::in(['Masculin', 'Féminin'])],
            'student.cin' => 'required|string|max:10',
            'student.date_birth' => [
                'required',
                'date',
                function($attribute, $value, $fail) {
                    $age = date_diff(date_create($value), date_create('today'))->y;
                    if ($age < 18) {
                        $fail("You are not allowed because you are under 18.");
                    }
                },
            ],
            'student.place_birth' => 'required|string|max:50',
            'student.address' => 'required|string|max:150',
            'student.city' => 'required|string|max:30',
            'student.phone' => 'required|string|max:15',
            'student.firstname_ar' => 'required|string|max:50',
            'student.lastname_ar' => 'required|string|max:50',
            'student.place_birth_ar' => 'required|string|max:50',
            'student.address_ar' => 'required|string|max:150',
            'photo' => 'nullable|image|max:1024|mimes:jpg,jpeg,png'
        ];
    }

    public function updatedStudentCin($value)
    {
        $this->student->cin = strtoupper($value);
    }

    public function updatedStudentFirstname($value)
    {
        $this->student->firstname = strtoupper($value);
    }

    public function updatedStudentLastname($value)
    {
        $this->student->lastname = strtoupper($value);
    }

    public function updatedStudentPlaceBirth($value)
    {
        $this->student->place_birth = strtoupper($value);
    }

    public function updatedStudentAddress($value)
    {
        $this->student->address = strtoupper($value);
    }

    public function updatedStudentCity($value)
    {
        $this->student->city = strtoupper($value);
    }

    public function updatedDateBirth($value)
    {
        if ($value) {
            $this->student->date_birth = $value;
        }
    }

    public function mount()
    {
        $this->student = new StudentModel();
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
        $this->reset(['photo', 'date_birth', 'student']); // Reset photo, date_birth, and student
        $this->student = new StudentModel();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $this->reset(['photo', 'date_birth']); // Ensure photo is reset

        $this->student = StudentModel::findOrFail($id);
        
        // Format date for the input
        if ($this->student->date_birth) {
            $this->date_birth = $this->student->date_birth->format('Y-m-d');
        }

        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();
        
        if ($this->date_birth) {
            $this->student->date_birth = $this->date_birth;
        }

        // Handle photo upload
        if ($this->photo) {
            // Delete old photo if it exists
            if ($this->student->image_url) {
                Storage::disk('public')->delete($this->student->image_url);
            }

            // Store new photo
            $filename = time() . '_' . $this->photo->getClientOriginalName();
            $this->photo->storeAs('photos', $filename, 'public');
            $this->student->image_url = 'photos/' . $filename;
        }

        if (!$this->student->exists) {
            $this->student->insert_user = auth()->user()->email;
            $this->student->reg_date = now();
        }

        $this->student->save();
        
        $this->showSavedAlert = true;
        $this->showModal = false;
        $this->reset(['photo', 'date_birth', 'student']); // Ensure reset after saving
        $this->student = new StudentModel();
        $this->emit('refresh');
    }

    public function confirmDelete($id)
    {
        $this->studentIdBeingDeleted = $id;
        $this->showDeleteModal = true;
    }

    public function deleteStudent()
    {
        $student = StudentModel::findOrFail($this->studentIdBeingDeleted);
        
        if ($student->image_url && Storage::disk('public')->exists($student->image_url)) {
            Storage::disk('public')->delete($student->image_url);
        }
        
        $student->delete();
        $this->showDeleteModal = false;
        $this->showSavedAlert = true;
        $this->emit('refresh');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetValidation();
        $this->reset(['photo', 'date_birth', 'student']); // Reset photo, date_birth, and student
        $this->editMode = false;
    }

    public function resetFilters()
    {
        $this->reset('searchTerm', 'filters', 'sortField', 'sortDirection');
    }

    public function removePhoto()
    {
        if ($this->student && $this->student->image_url) {
            Storage::disk('public')->delete($this->student->image_url);
            $this->student->image_url = null;
            $this->student->save();
        }
        $this->reset('photo');
        $this->emit('refresh');
    }

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:1024|mimes:jpg,jpeg,png'
        ]);
    }

    public function hydrate()
    {
        if (!$this->student) {
            $this->student = new StudentModel();
        }
    }

    public function addDossier($studentId)
    {
        $this->dossier['student_id'] = $studentId;
        $this->showDossierModal = true;
    }

    public function saveDossier()
    {
        $this->validate([
            'dossier.category' => 'required|string|max:2',
            'dossier.price' => 'required|integer',
            'dossier.ref' => 'required|string|max:6',
            'dossier.student_id' => 'required|exists:students,id'
        ]);

        try {
            $dossier = Dossier::create([
                'category' => $this->dossier['category'],
                'price' => $this->dossier['price'],
                'ref' => $this->dossier['ref'],
                'student_id' => $this->dossier['student_id'],
                'insert_user' => auth()->user()->name,
                'date_inscription' => now(),
                'status' => true,
                'resultat' => false
            ]);

            $this->showDossierModal = false;
            $this->dossier = [
                'category' => '',
                'price' => '',
                'ref' => '',
                'student_id' => null
            ];
            $this->showSavedAlert = true;
            session()->flash('success', 'Dossier créé avec succès.');
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la création du dossier: ' . $e->getMessage());
        }
    }

    public function closeDossierModal()
    {
        $this->showDossierModal = false;
        $this->dossier = [
            'category' => '',
            'price' => '',
            'ref' => '',
            'student_id' => null
        ];
    }

    public function render()
    {
        $students = StudentModel::query()
            ->when($this->searchTerm, function($query) {
                $query->where(function($query) {
                    $query->where('firstname', 'like', '%'.$this->searchTerm.'%')
                        ->orWhere('lastname', 'like', '%'.$this->searchTerm.'%')
                        ->orWhere('cin', 'like', '%'.$this->searchTerm.'%')
                        ->orWhere('phone', 'like', '%'.$this->searchTerm.'%');
                });
            })
            ->when(isset($this->filters['gender']) && $this->filters['gender'], function($query) {
                $query->where('gender', $this->filters['gender']);
            })
            ->when(isset($this->filters['city']) && $this->filters['city'], function($query) {
                $query->where('city', $this->filters['city']);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        $cities = StudentModel::distinct('city')->pluck('city')->filter();

        return view('livewire.student', [
            'students' => $students,
            'cities' => $cities
        ]);
    }
} 
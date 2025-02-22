<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class Users extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $showModal = false;
    public $showDeleteModal = false;
    public $userIdBeingDeleted = null;
    public $searchTerm = '';
    public $user = [
        'name' => '',
        'email' => '',
        'role' => '',
        'password' => '',
        'password_confirmation' => ''
    ];
    public $editMode = false;
    public $userId;

    protected $listeners = ['delete' => 'deleteUser'];

    protected function rules()
    {
        return [
            'user.name' => 'required|min:3',
            'user.email' => ['required', 'email', $this->editMode 
                ? Rule::unique('users', 'email')->ignore($this->userId)
                : Rule::unique('users', 'email')],
            'user.role' => 'required|in:admin,user',
            'user.password' => $this->editMode 
                ? 'nullable|min:6|same:user.password_confirmation'
                : 'required|min:6|same:user.password_confirmation',
        ];
    }

    public function mount()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Accès non autorisé.');
        }
    }

    public function updatedSearchTerm()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetValidation();
        $this->editMode = false;
        $this->user = [
            'name' => '',
            'email' => '',
            'role' => 'user',
            'password' => '',
            'password_confirmation' => ''
        ];
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $this->editMode = true;
        $this->userId = $id;
        $user = User::find($id);
        $this->user = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'password' => '',
            'password_confirmation' => ''
        ];
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->editMode) {
                $user = User::find($this->userId);
                $userData = [
                    'name' => $this->user['name'],
                    'email' => $this->user['email'],
                    'role' => $this->user['role']
                ];
                
                if (!empty($this->user['password'])) {
                    $userData['password'] = Hash::make($this->user['password']);
                }
                
                $user->update($userData);
                session()->flash('success', 'Utilisateur mis à jour avec succès.');
            } else {
                User::create([
                    'name' => $this->user['name'],
                    'email' => $this->user['email'],
                    'role' => $this->user['role'],
                    'password' => $this->user['password']
                ]);
                session()->flash('success', 'Utilisateur créé avec succès.');
            }

            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    public function confirmDelete($id)
    {
        if ($id == auth()->id()) {
            session()->flash('error', 'Vous ne pouvez pas supprimer votre propre compte.');
            return;
        }
        $this->userIdBeingDeleted = $id;
        $this->showDeleteModal = true;
    }

    public function deleteUser()
    {
        try {
            $user = User::find($this->userIdBeingDeleted);
            if ($user && $user->id !== auth()->id()) {
                $user->delete();
                session()->flash('success', 'Utilisateur supprimé avec succès.');
            }
            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Une erreur est survenue lors de la suppression.');
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->resetValidation();
        $this->reset(['user', 'editMode', 'userId', 'userIdBeingDeleted']);
    }

    public function render()
    {
        $users = User::where(function($query) {
            $query->where('name', 'like', '%'.$this->searchTerm.'%')
                  ->orWhere('email', 'like', '%'.$this->searchTerm.'%')
                  ->orWhere('role', 'like', '%'.$this->searchTerm.'%');
        })->paginate(10);

        return view('livewire.users', [
            'users' => $users
        ]);
    }
}

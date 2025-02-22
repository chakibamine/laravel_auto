<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Register extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $passwordConfirmation = '';

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|same:passwordConfirmation',
    ];

    protected $messages = [
        'name.required' => 'Le nom est requis',
        'name.min' => 'Le nom doit contenir au moins 3 caractères',
        'email.required' => 'L\'email est requis',
        'email.email' => 'L\'email n\'est pas valide',
        'email.unique' => 'Cet email est déjà utilisé',
        'password.required' => 'Le mot de passe est requis',
        'password.min' => 'Le mot de passe doit contenir au moins 6 caractères',
        'password.same' => 'Les mots de passe ne correspondent pas'
    ];

    public function mount()
    {
        if (auth()->user()) {
            return redirect()->intended('/dashboard');
        }
    }

    public function updatedEmail()
    {
        $this->validate(['email' => 'required|email|unique:users']);
    }
    
    public function register()
    {
        $this->validate();

        try {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
                'role' => 'user',
                'remember_token' => Str::random(10),
            ]);

            auth()->login($user);
            
            session()->regenerate();
            return redirect()->intended('/dashboard');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Une erreur est survenue lors de l\'inscription.');
            return;
        }
    }

    public function render()
    {
        return view('livewire.auth.register')
            ->layout('layouts.auth');
    }
}
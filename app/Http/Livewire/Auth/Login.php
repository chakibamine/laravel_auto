<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember_me = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6'
    ];

    protected $messages = [
        'email.required' => 'L\'adresse email est requise',
        'email.email' => 'L\'adresse email n\'est pas valide',
        'password.required' => 'Le mot de passe est requis',
        'password.min' => 'Le mot de passe doit contenir au moins 6 caractères'
    ];

    public function mount()
    {
        if (Auth::check()) {
            return redirect()->intended('/dashboard');
        }
    }

    public function login()
    {
        $this->validate();

        try {
            // Get the user first to check if they exist
            $user = User::where('email', $this->email)->first();
            
            if (!$user) {
                $this->addError('email', 'Aucun compte trouvé avec cette adresse email.');
                $this->password = '';
                return;
            }

            // Attempt to authenticate
            if (Auth::attempt([
                'email' => $this->email,
                'password' => $this->password
            ], $this->remember_me)) {
                session()->regenerate();
                Log::info('User logged in successfully', ['user_id' => $user->id, 'email' => $user->email]);
                return redirect()->intended('/dashboard');
            }

            // Authentication failed - password incorrect
            $this->addError('password', 'Le mot de passe est incorrect.');
            $this->password = '';
            
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage(), [
                'email' => $this->email,
                'trace' => $e->getTraceAsString()
            ]);
            $this->addError('email', 'Une erreur est survenue lors de la connexion.');
            $this->password = '';
        }
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('layouts.auth');
    }
}
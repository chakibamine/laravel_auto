<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class ConfirmModal extends Component
{
    public $showModal = false;
    public $title;
    public $message;
    public $confirmButtonText;
    public $cancelButtonText;
    public $confirmButtonClass;
    public $data;

    protected $listeners = ['confirm' => 'show'];

    public function mount(
        $title = 'Confirmation',
        $message = 'Are you sure you want to proceed?',
        $confirmButtonText = 'Confirm',
        $cancelButtonText = 'Cancel',
        $confirmButtonClass = 'btn-danger'
    ) {
        $this->title = $title;
        $this->message = $message;
        $this->confirmButtonText = $confirmButtonText;
        $this->cancelButtonText = $cancelButtonText;
        $this->confirmButtonClass = $confirmButtonClass;
    }

    public function show($data = null)
    {
        $this->data = $data;
        $this->showModal = true;
    }

    public function confirm()
    {
        $this->showModal = false;
        $this->emitUp('confirmed', $this->data);
    }

    public function cancel()
    {
        $this->showModal = false;
        $this->emitUp('cancelled');
    }

    public function render()
    {
        return view('livewire.components.confirm-modal');
    }
} 
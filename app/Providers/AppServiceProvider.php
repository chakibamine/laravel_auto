<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Http\Livewire\Components\PaymentModal;
use App\Http\Livewire\Components\ConfirmModal;
use App\Http\Livewire\Components\ExamModal;
use App\Http\Livewire\Components\AddCourModal;
use App\Http\Livewire\CourList;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Livewire::component('components.exam-modal', ExamModal::class);
        Livewire::component('components.add-cour-modal', AddCourModal::class);
        Livewire::component('payment-modal', PaymentModal::class);
        Livewire::component('confirm-modal', ConfirmModal::class);
        Livewire::component('cour-list', CourList::class);
    }
}

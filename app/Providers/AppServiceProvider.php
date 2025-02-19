<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Http\Livewire\Components\PaymentModal;
use App\Http\Livewire\Components\ConfirmModal;

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
        Livewire::component('payment-modal', PaymentModal::class);
        Livewire::component('confirm-modal', ConfirmModal::class);
    }
}

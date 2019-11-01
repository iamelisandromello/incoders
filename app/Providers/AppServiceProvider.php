<?php

namespace App\Providers;

use App\Contracts\InvoiceService;
use App\Services\LogInvoiceService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $concrect = env('INVOICE_SERVICE') === 'log' ? LogInvoiceService::class : InovacaoInvoiceService::class;

        $this->app->bind(InvoiceService::class, $concrect);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

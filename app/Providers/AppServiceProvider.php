<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Show the demo credentials hint above the login form.
        FilamentView::registerRenderHook(
            PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE,
            fn (): string => Blade::render(<<<'BLADE'
                <style>
                    .demo-creds {
                        border-radius: 0.75rem;
                        padding: 0.875rem 1rem;
                        font-size: 0.8125rem;
                        line-height: 1.4;
                        color: #92400e;
                        background: rgba(245, 158, 11, 0.1);
                        border: 1px solid rgba(245, 158, 11, 0.3);
                    }
                    .dark .demo-creds { color: #fcd34d; }
                    .demo-creds .title { font-weight: 700; }
                    .demo-creds .row { margin-top: 0.375rem; }
                    .demo-creds code {
                        font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
                        font-weight: 600;
                    }
                </style>
                <div class="demo-creds">
                    <p class="title">Demo credentials</p>
                    <p class="row">Email <code>demo@example.com</code></p>
                    <p class="row">Password <code>password</code></p>
                </div>
            BLADE),
        );
    }
}

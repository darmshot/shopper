<?php

declare(strict_types=1);

namespace App\Providers;

use App\Foundation\Mixins\CurrencyApplicationMixin;
use App\Services\Money\Money;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Override;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[Override]
    public function register(): void
    {
        include_once __DIR__.'./../functions.php';

        $this->app->scoped('money', fn (Application $app) => new Money(
            /** @phpstan-ignore-next-line */
            currency: $app->getCurrency(),
            locale: $app->getLocale(),
        ));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->configureMixins();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );

        Blade::anonymousComponentPath(resource_path('views/admin/components'), 'admin');
        Blade::anonymousComponentPath(resource_path('views/design/components'), 'design');

        Blade::componentNamespace('App\\View\\Admin\\Components', 'admin');
        Blade::componentNamespace('App\\View\\Design\\Components', 'design');

        Model::preventLazyLoading(! $this->app->isProduction());
    }

    protected function configureMixins(): void
    {
        Application::mixin(new CurrencyApplicationMixin);
    }
}

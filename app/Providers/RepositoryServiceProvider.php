<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Repositories\CategoryRepository;
use Illuminate\Support\ServiceProvider;
use Override;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string,class-string>
     */
    private array $repositories = [
        CategoryRepository::class => \App\Repositories\Eloquent\CategoryRepository::class,
    ];

    /**
     * @var array<class-string,class-string>
     */
    private array $objectRepositories = [
        //        \App\Contracts\Repositories\CategoryRepository::class => \App\Repositories\Object\CategoryRepository::class,
    ];

    /**
     * Register any application services.
     */
    #[Override]
    public function register(): void
    {
        $this->registerRepositories();

        $this->registerObjectRepositories();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    private function registerRepositories(): void
    {
        foreach ($this->repositories as $abstract => $concrete) {
            $this->app->scoped($abstract, $concrete);
        }
    }

    private function registerObjectRepositories(): void
    {
        foreach ($this->objectRepositories as $abstract => $concrete) {
            $this->app->extend($abstract, fn ($service) => new $concrete($service));
        }
    }
}

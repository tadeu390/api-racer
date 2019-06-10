<?php
namespace App\Providers;

use App\Repositories\Contracts\CorredorRepositoryInterface;
use App\Repositories\Contracts\ProvaRepositoryInterface;
use App\Repositories\Contracts\ResultadoRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Core\EloquentCorredorRepository;
use App\Repositories\Core\EloquentProvaRepository;
use App\Repositories\Core\EloquentResultadoRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            CorredorRepositoryInterface::class,
            EloquentCorredorRepository::class
        );

        $this->app->bind(
            ProvaRepositoryInterface::class,
            EloquentProvaRepository::class
        );

        $this->app->bind(
            ResultadoRepositoryInterface::class,
            EloquentResultadoRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

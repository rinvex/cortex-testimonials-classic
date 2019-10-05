<?php

declare(strict_types=1);

namespace Cortex\Testimonials\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Rinvex\Support\Traits\ConsoleTools;
use Cortex\Testimonials\Models\Testimonial;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Relations\Relation;
use Cortex\Testimonials\Console\Commands\SeedCommand;
use Cortex\Testimonials\Console\Commands\InstallCommand;
use Cortex\Testimonials\Console\Commands\MigrateCommand;
use Cortex\Testimonials\Console\Commands\PublishCommand;
use Cortex\Testimonials\Console\Commands\RollbackCommand;

class TestimonialsServiceProvider extends ServiceProvider
{
    use ConsoleTools;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        SeedCommand::class => 'command.cortex.testimonials.seed',
        InstallCommand::class => 'command.cortex.testimonials.install',
        MigrateCommand::class => 'command.cortex.testimonials.migrate',
        PublishCommand::class => 'command.cortex.testimonials.publish',
        RollbackCommand::class => 'command.cortex.testimonials.rollback',
    ];

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     *
     * @return void
     */
    public function register(): void
    {
        // Bind eloquent models to IoC container
        $this->app['config']['rinvex.testimonials.models.testimonial'] === Testimonial::class
        || $this->app->alias('rinvex.testimonials.testimonial', Testimonial::class);

        // Register console commands
        ! $this->app->runningInConsole() || $this->registerCommands();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router, Dispatcher $dispatcher): void
    {
        // Bind route models and constrains
        $router->pattern('testimonial', '[a-zA-Z0-9-]+');
        $router->model('testimonial', config('rinvex.testimonials.models.testimonial'));

        // Map relations
        Relation::morphMap([
            'testimonial' => config('rinvex.testimonials.models.testimonial'),
        ]);

        // Load resources
        $this->loadRoutesFrom(__DIR__.'/../../routes/web/adminarea.php');
        $this->loadRoutesFrom(__DIR__.'/../../routes/web/managerarea.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'cortex/testimonials');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'cortex/testimonials');

        $this->app->runningInConsole() || $dispatcher->listen('controller.constructed', function ($accessarea) {
            ! file_exists($menus = __DIR__."/../../routes/menus/{$accessarea}.php") || require $menus;
            ! file_exists($breadcrumbs = __DIR__."/../../routes/breadcrumbs/{$accessarea}.php") || require $breadcrumbs;
        });

        // Publish Resources
        ! $this->app->runningInConsole() || $this->publishesLang('cortex/testimonials', true);
        ! $this->app->runningInConsole() || $this->publishesViews('cortex/testimonials', true);
        ! $this->app->runningInConsole() || $this->publishesMigrations('cortex/testimonials', true);
    }
}

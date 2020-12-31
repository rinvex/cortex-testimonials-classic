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
use Cortex\Testimonials\Console\Commands\UnloadCommand;
use Cortex\Testimonials\Console\Commands\InstallCommand;
use Cortex\Testimonials\Console\Commands\MigrateCommand;
use Cortex\Testimonials\Console\Commands\PublishCommand;
use Cortex\Testimonials\Console\Commands\ActivateCommand;
use Cortex\Testimonials\Console\Commands\AutoloadCommand;
use Cortex\Testimonials\Console\Commands\RollbackCommand;
use Cortex\Testimonials\Console\Commands\DeactivateCommand;

class TestimonialsServiceProvider extends ServiceProvider
{
    use ConsoleTools;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        ActivateCommand::class => 'command.cortex.testimonials.activate',
        DeactivateCommand::class => 'command.cortex.testimonials.deactivate',
        AutoloadCommand::class => 'command.cortex.testimonials.autoload',
        UnloadCommand::class => 'command.cortex.testimonials.unload',

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
        $this->registerCommands($this->commands);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router, Dispatcher $dispatcher): void
    {
        // Bind route models and constrains
        $router->pattern('testimonial', '[a-zA-Z0-9-_]+');
        $router->model('testimonial', config('rinvex.testimonials.models.testimonial'));

        // Map relations
        Relation::morphMap([
            'testimonial' => config('rinvex.testimonials.models.testimonial'),
        ]);
    }
}

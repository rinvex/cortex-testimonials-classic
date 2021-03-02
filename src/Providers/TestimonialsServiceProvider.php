<?php

declare(strict_types=1);

namespace Cortex\Testimonials\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Rinvex\Support\Traits\ConsoleTools;
use Cortex\Testimonials\Models\Testimonial;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Relations\Relation;

class TestimonialsServiceProvider extends ServiceProvider
{
    use ConsoleTools;

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

<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;

class CortexTestimonialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bouncer::allow('admin')->to('list', config('rinvex.testimonials.models.testimonial'));
        Bouncer::allow('admin')->to('create', config('rinvex.testimonials.models.testimonial'));
        Bouncer::allow('admin')->to('update', config('rinvex.testimonials.models.testimonial'));
        Bouncer::allow('admin')->to('delete', config('rinvex.testimonials.models.testimonial'));
        Bouncer::allow('admin')->to('audit', config('rinvex.testimonials.models.testimonial'));

        Bouncer::allow('owner')->to('list', config('rinvex.testimonials.models.testimonial'));
        Bouncer::allow('owner')->to('create', config('rinvex.testimonials.models.testimonial'));
        Bouncer::allow('owner')->to('update', config('rinvex.testimonials.models.testimonial'));
        Bouncer::allow('owner')->to('delete', config('rinvex.testimonials.models.testimonial'));
        Bouncer::allow('owner')->to('audit', config('rinvex.testimonials.models.testimonial'));
    }
}

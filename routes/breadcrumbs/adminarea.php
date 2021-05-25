<?php

declare(strict_types=1);

use Diglactic\Breadcrumbs\Generator;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Cortex\Testimonials\Models\Testimonial;

Breadcrumbs::for('adminarea.cortex.testimonials.testimonials.index', function (Generator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/testimonials::common.testimonials'), route('adminarea.cortex.testimonials.testimonials.index'));
});

Breadcrumbs::for('adminarea.cortex.testimonials.testimonials.import', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.testimonials.testimonials.index');
    $breadcrumbs->push(trans('cortex/testimonials::common.import'), route('adminarea.cortex.testimonials.testimonials.import'));
});

Breadcrumbs::for('adminarea.cortex.testimonials.testimonials.import.logs', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.testimonials.testimonials.index');
    $breadcrumbs->push(trans('cortex/testimonials::common.import'), route('adminarea.cortex.testimonials.testimonials.import'));
    $breadcrumbs->push(trans('cortex/testimonials::common.logs'), route('adminarea.cortex.testimonials.testimonials.import.logs'));
});

Breadcrumbs::for('adminarea.cortex.testimonials.testimonials.create', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.testimonials.testimonials.index');
    $breadcrumbs->push(trans('cortex/testimonials::common.create_testimonial'), route('adminarea.cortex.testimonials.testimonials.create'));
});

Breadcrumbs::for('adminarea.cortex.testimonials.testimonials.edit', function (Generator $breadcrumbs, Testimonial $testimonial) {
    $breadcrumbs->parent('adminarea.cortex.testimonials.testimonials.index');
    $breadcrumbs->push(trans('cortex/testimonials::common.testimonial', ['id' => $testimonial->getRouteKey()]), route('adminarea.cortex.testimonials.testimonials.edit', ['testimonial' => $testimonial]));
});

Breadcrumbs::for('adminarea.cortex.testimonials.testimonials.logs', function (Generator $breadcrumbs, Testimonial $testimonial) {
    $breadcrumbs->parent('adminarea.cortex.testimonials.testimonials.index');
    $breadcrumbs->push(trans('cortex/testimonials::common.testimonial', ['id' => $testimonial->getRouteKey()]), route('adminarea.cortex.testimonials.testimonials.edit', ['testimonial' => $testimonial]));
    $breadcrumbs->push(trans('cortex/testimonials::common.logs'), route('adminarea.cortex.testimonials.testimonials.logs', ['testimonial' => $testimonial]));
});

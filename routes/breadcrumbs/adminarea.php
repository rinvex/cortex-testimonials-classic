<?php

declare(strict_types=1);

use Cortex\Testimonials\Models\Testimonial;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('adminarea.cortex.testimonials.testimonials.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/testimonials::common.testimonials'), route('adminarea.cortex.testimonials.testimonials.index'));
});

Breadcrumbs::register('adminarea.cortex.testimonials.testimonials.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.testimonials.testimonials.index');
    $breadcrumbs->push(trans('cortex/testimonials::common.import'), route('adminarea.cortex.testimonials.testimonials.import'));
});

Breadcrumbs::register('adminarea.cortex.testimonials.testimonials.import.logs', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.testimonials.testimonials.index');
    $breadcrumbs->push(trans('cortex/testimonials::common.import'), route('adminarea.cortex.testimonials.testimonials.import'));
    $breadcrumbs->push(trans('cortex/testimonials::common.logs'), route('adminarea.cortex.testimonials.testimonials.import.logs'));
});

Breadcrumbs::register('adminarea.cortex.testimonials.testimonials.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.testimonials.testimonials.index');
    $breadcrumbs->push(trans('cortex/testimonials::common.create_testimonial'), route('adminarea.cortex.testimonials.testimonials.create'));
});

Breadcrumbs::register('adminarea.cortex.testimonials.testimonials.edit', function (BreadcrumbsGenerator $breadcrumbs, Testimonial $testimonial) {
    $breadcrumbs->parent('adminarea.cortex.testimonials.testimonials.index');
    $breadcrumbs->push(trans('cortex/testimonials::common.testimonial', ['id' => $testimonial->getRouteKey()]), route('adminarea.cortex.testimonials.testimonials.edit', ['testimonial' => $testimonial]));
});

Breadcrumbs::register('adminarea.cortex.testimonials.testimonials.logs', function (BreadcrumbsGenerator $breadcrumbs, Testimonial $testimonial) {
    $breadcrumbs->parent('adminarea.cortex.testimonials.testimonials.index');
    $breadcrumbs->push(trans('cortex/testimonials::common.testimonial', ['id' => $testimonial->getRouteKey()]), route('adminarea.cortex.testimonials.testimonials.edit', ['testimonial' => $testimonial]));
    $breadcrumbs->push(trans('cortex/testimonials::common.logs'), route('adminarea.cortex.testimonials.testimonials.logs', ['testimonial' => $testimonial]));
});

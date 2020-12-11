<?php

declare(strict_types=1);

use Cortex\Testimonials\Models\Testimonial;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('managerarea.cortex.testimonials.testimonials.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.app('request.tenant')->name, route('managerarea.home'));
    $breadcrumbs->push(trans('cortex/testimonials::common.testimonials'), route('managerarea.cortex.testimonials.testimonials.index'));
});

Breadcrumbs::register('managerarea.cortex.testimonials.testimonials.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.cortex.testimonials.testimonials.index');
    $breadcrumbs->push(trans('cortex/testimonials::common.import'), route('managerarea.cortex.testimonials.testimonials.import'));
});

Breadcrumbs::register('managerarea.cortex.testimonials.testimonials.import.logs', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.cortex.testimonials.testimonials.index');
    $breadcrumbs->push(trans('cortex/testimonials::common.import'), route('managerarea.cortex.testimonials.testimonials.import'));
    $breadcrumbs->push(trans('cortex/testimonials::common.logs'), route('managerarea.cortex.testimonials.testimonials.import.logs'));
});

Breadcrumbs::register('managerarea.cortex.testimonials.testimonials.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.cortex.testimonials.testimonials.index');
    $breadcrumbs->push(trans('cortex/testimonials::common.create_testimonial'), route('managerarea.cortex.testimonials.testimonials.create'));
});

Breadcrumbs::register('managerarea.cortex.testimonials.testimonials.edit', function (BreadcrumbsGenerator $breadcrumbs, Testimonial $testimonial) {
    $breadcrumbs->parent('managerarea.cortex.testimonials.testimonials.index');
    $breadcrumbs->push(trans('cortex/testimonials::common.testimonial', ['id' => $testimonial->getRouteKey()]), route('managerarea.cortex.testimonials.testimonials.edit', ['testimonial' => $testimonial]));
});

Breadcrumbs::register('managerarea.cortex.testimonials.testimonials.logs', function (BreadcrumbsGenerator $breadcrumbs, Testimonial $testimonial) {
    $breadcrumbs->parent('managerarea.cortex.testimonials.testimonials.index');
    $breadcrumbs->push(trans('cortex/testimonials::common.testimonial', ['id' => $testimonial->getRouteKey()]), route('managerarea.cortex.testimonials.testimonials.edit', ['testimonial' => $testimonial]));
    $breadcrumbs->push(trans('cortex/testimonials::common.logs'), route('managerarea.cortex.testimonials.testimonials.logs', ['testimonial' => $testimonial]));
});

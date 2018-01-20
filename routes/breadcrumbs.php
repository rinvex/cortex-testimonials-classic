<?php

declare(strict_types=1);

use Rinvex\Testimonials\Models\Testimonial;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

// Adminarea breadcrumbs
Breadcrumbs::register('adminarea.testimonials.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.adminarea'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/testimonials::common.testimonials'), route('adminarea.testimonials.index'));
});

Breadcrumbs::register('adminarea.testimonials.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.testimonials.index');
    $breadcrumbs->push(trans('cortex/testimonials::common.create_testimonial'), route('adminarea.testimonials.create'));
});

Breadcrumbs::register('adminarea.testimonials.edit', function (BreadcrumbsGenerator $breadcrumbs, Testimonial $testimonial) {
    $breadcrumbs->parent('adminarea.testimonials.index');
    $breadcrumbs->push(trans('cortex/testimonials::common.testimonial', ['id' => $testimonial->getKey()]), route('adminarea.testimonials.edit', ['testimonial' => $testimonial]));
});

Breadcrumbs::register('adminarea.testimonials.logs', function (BreadcrumbsGenerator $breadcrumbs, Testimonial $testimonial) {
    $breadcrumbs->parent('adminarea.testimonials.index');
    $breadcrumbs->push(trans('cortex/testimonials::common.testimonial', ['id' => $testimonial->getKey()]), route('adminarea.testimonials.edit', ['testimonial' => $testimonial]));
    $breadcrumbs->push(trans('cortex/testimonials::common.logs'), route('adminarea.testimonials.logs', ['testimonial' => $testimonial]));
});

// Managerarea breadcrumbs
Breadcrumbs::register('managerarea.testimonials.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/tenants::common.managerarea'), route('managerarea.home'));
    $breadcrumbs->push(trans('cortex/testimonials::common.testimonials'), route('managerarea.testimonials.index'));
});

Breadcrumbs::register('managerarea.testimonials.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.testimonials.index');
    $breadcrumbs->push(trans('cortex/testimonials::common.create_testimonial'), route('managerarea.testimonials.create'));
});

Breadcrumbs::register('managerarea.testimonials.edit', function (BreadcrumbsGenerator $breadcrumbs, Testimonial $testimonial) {
    $breadcrumbs->parent('managerarea.testimonials.index');
    $breadcrumbs->push(trans('cortex/testimonials::common.testimonial', ['id' => $testimonial->getKey()]), route('managerarea.testimonials.edit', ['testimonial' => $testimonial]));
});

Breadcrumbs::register('managerarea.testimonials.logs', function (BreadcrumbsGenerator $breadcrumbs, Testimonial $testimonial) {
    $breadcrumbs->parent('managerarea.testimonials.index');
    $breadcrumbs->push(trans('cortex/testimonials::common.testimonial', ['id' => $testimonial->getKey()]), route('managerarea.testimonials.edit', ['testimonial' => $testimonial]));
    $breadcrumbs->push(trans('cortex/testimonials::common.logs'), route('managerarea.testimonials.logs', ['testimonial' => $testimonial]));
});

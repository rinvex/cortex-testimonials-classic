<?php

declare(strict_types=1);

use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Models\MenuGenerator;
use Cortex\Testimonials\Models\Testimonial;

Menu::register('adminarea.sidebar', function (MenuGenerator $menu) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.crm'), 50, 'fa fa-briefcase', [], function (MenuItem $dropdown) {
        $dropdown->route(['adminarea.testimonials.index'], trans('cortex/testimonials::common.testimonials'), 10, 'fa fa-quote-right')->ifCan('list-testimonials')->activateOnRoute('adminarea.testimonials');
    });
});

Menu::register('managerarea.sidebar', function (MenuGenerator $menu) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.crm'), 50, 'fa fa-briefcase', [], function (MenuItem $dropdown) {
        $dropdown->route(['managerarea.testimonials.index'], trans('cortex/testimonials::common.testimonials'), 10, 'fa fa-quote-right')->ifCan('list-testimonials')->activateOnRoute('managerarea.testimonials');
    });
});

Menu::register('adminarea.testimonials.tabs', function (MenuGenerator $menu, Testimonial $testimonial) {
    $menu->route(['adminarea.testimonials.create'], trans('cortex/bookings::common.details'))->ifCan('create-testimonials')->if(! $testimonial->exists);
    $menu->route(['adminarea.testimonials.edit', ['testimonial' => $testimonial]], trans('cortex/bookings::common.details'))->ifCan('update-testimonials')->if($testimonial->exists);
    $menu->route(['adminarea.testimonials.logs', ['testimonial' => $testimonial]], trans('cortex/bookings::common.logs'))->ifCan('update-testimonials')->if($testimonial->exists);
    $menu->route(['adminarea.testimonials.media.index', ['testimonial' => $testimonial]], trans('cortex/bookings::common.media'))->ifCan('list-media-testimonials')->if($testimonial->exists);
});

Menu::register('managerarea.testimonials.tabs', function (MenuGenerator $menu, Testimonial $testimonial) {
    $menu->route(['managerarea.testimonials.create'], trans('cortex/bookings::common.details'))->ifCan('create-testimonials')->if(! $testimonial->exists);
    $menu->route(['managerarea.testimonials.edit', ['testimonial' => $testimonial]], trans('cortex/bookings::common.details'))->ifCan('update-testimonials')->if($testimonial->exists);
    $menu->route(['managerarea.testimonials.logs', ['testimonial' => $testimonial]], trans('cortex/bookings::common.logs'))->ifCan('update-testimonials')->if($testimonial->exists);
    $menu->route(['managerarea.testimonials.media.index', ['testimonial' => $testimonial]], trans('cortex/bookings::common.media'))->ifCan('list-media-testimonials')->if($testimonial->exists);
});

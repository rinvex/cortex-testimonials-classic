<?php

declare(strict_types=1);

use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Models\MenuGenerator;
use Cortex\Testimonials\Models\Testimonial;

Menu::register('adminarea.sidebar', function (MenuGenerator $menu, Testimonial $testimonial) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.crm'), 50, 'fa fa-briefcase', [], function (MenuItem $dropdown) use ($testimonial) {
        $dropdown->route(['adminarea.testimonials.index'], trans('cortex/testimonials::common.testimonials'), 10, 'fa fa-quote-right')->ifCan('list', $testimonial)->activateOnRoute('adminarea.testimonials');
    });
});

Menu::register('managerarea.sidebar', function (MenuGenerator $menu, Testimonial $testimonial) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.crm'), 50, 'fa fa-briefcase', [], function (MenuItem $dropdown) use ($testimonial) {
        $dropdown->route(['managerarea.testimonials.index'], trans('cortex/testimonials::common.testimonials'), 10, 'fa fa-quote-right')->ifCan('list', $testimonial)->activateOnRoute('managerarea.testimonials');
    });
});

Menu::register('adminarea.testimonials.tabs', function (MenuGenerator $menu, Testimonial $testimonial) {
    $menu->route(['adminarea.testimonials.create'], trans('cortex/bookings::common.details'))->ifCan('create', $testimonial)->if(! $testimonial->exists);
    $menu->route(['adminarea.testimonials.edit', ['testimonial' => $testimonial]], trans('cortex/bookings::common.details'))->ifCan('update', $testimonial)->if($testimonial->exists);
    $menu->route(['adminarea.testimonials.logs', ['testimonial' => $testimonial]], trans('cortex/bookings::common.logs'))->ifCan('audit', $testimonial)->if($testimonial->exists);
});

Menu::register('managerarea.testimonials.tabs', function (MenuGenerator $menu, Testimonial $testimonial) {
    $menu->route(['managerarea.testimonials.create'], trans('cortex/bookings::common.details'))->ifCan('create', $testimonial)->if(! $testimonial->exists);
    $menu->route(['managerarea.testimonials.edit', ['testimonial' => $testimonial]], trans('cortex/bookings::common.details'))->ifCan('update', $testimonial)->if($testimonial->exists);
    $menu->route(['managerarea.testimonials.logs', ['testimonial' => $testimonial]], trans('cortex/bookings::common.logs'))->ifCan('audit', $testimonial)->if($testimonial->exists);
});

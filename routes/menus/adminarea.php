<?php

declare(strict_types=1);

use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Models\MenuGenerator;
use Cortex\Testimonials\Models\Testimonial;

Menu::register('adminarea.sidebar', function (MenuGenerator $menu, Testimonial $testimonial) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.crm'), 50, 'fa fa-briefcase', 'header', [], function (MenuItem $dropdown) use ($testimonial) {
        $dropdown->route(['adminarea.testimonials.index'], trans('cortex/testimonials::common.testimonials'), 10, 'fa fa-quote-right')->ifCan('list', $testimonial)->activateOnRoute('adminarea.testimonials');
    });
});

Menu::register('adminarea.testimonials.tabs', function (MenuGenerator $menu, Testimonial $testimonial) {
    $menu->route(['adminarea.testimonials.import'], trans('cortex/bookings::common.records'))->ifCan('import', $testimonial)->if(Route::is('adminarea.testimonials.import*'));
    $menu->route(['adminarea.testimonials.import.logs'], trans('cortex/bookings::common.logs'))->ifCan('import', $testimonial)->if(Route::is('adminarea.testimonials.import*'));
    $menu->route(['adminarea.testimonials.create'], trans('cortex/bookings::common.details'))->ifCan('create', $testimonial)->if(Route::is('adminarea.testimonials.create'));
    $menu->route(['adminarea.testimonials.edit', ['testimonial' => $testimonial]], trans('cortex/bookings::common.details'))->ifCan('update', $testimonial)->if($testimonial->exists);
    $menu->route(['adminarea.testimonials.logs', ['testimonial' => $testimonial]], trans('cortex/bookings::common.logs'))->ifCan('audit', $testimonial)->if($testimonial->exists);
});

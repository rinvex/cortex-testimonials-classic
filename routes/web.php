<?php

declare(strict_types=1);

Route::domain(domain())->group(function () {

    Route::name('adminarea.')
         ->namespace('Cortex\Testimonials\Http\Controllers\Adminarea')
         ->middleware(['web', 'nohttpcache', 'can:access-adminarea'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/'.config('cortex.foundation.route.prefix.adminarea') : config('cortex.foundation.route.prefix.adminarea'))->group(function () {

        // Testimonials Routes
        Route::name('testimonials.')->prefix('testimonials')->group(function () {
            Route::get('/')->name('index')->uses('TestimonialsController@index');
            Route::get('create')->name('create')->uses('TestimonialsController@form');
            Route::post('create')->name('store')->uses('TestimonialsController@store');
            Route::get('{testimonial}')->name('edit')->uses('TestimonialsController@form');
            Route::put('{testimonial}')->name('update')->uses('TestimonialsController@update');
            Route::get('{testimonial}/logs')->name('logs')->uses('TestimonialsController@logs');
            Route::delete('{testimonial}')->name('delete')->uses('TestimonialsController@delete');
        });

    });

});


Route::domain('{subdomain}.'.domain())->group(function () {

    Route::name('managerarea.')
         ->namespace('Cortex\Testimonials\Http\Controllers\Managerarea')
         ->middleware(['web', 'nohttpcache', 'can:access-managerarea'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/'.config('cortex.tenants.route.prefix.managerarea') : config('cortex.tenants.route.prefix.managerarea'))->group(function () {

            // Testimonials Routes
            Route::name('testimonials.')->prefix('testimonials')->group(function () {
                Route::get('/')->name('index')->uses('TestimonialsController@index');
                Route::get('create')->name('create')->uses('TestimonialsController@form');
                Route::post('create')->name('store')->uses('TestimonialsController@store');
                Route::get('{testimonial}')->name('edit')->uses('TestimonialsController@form');
                Route::put('{testimonial}')->name('update')->uses('TestimonialsController@update');
                Route::get('{testimonial}/logs')->name('logs')->uses('TestimonialsController@logs');
                Route::delete('{testimonial}')->name('delete')->uses('TestimonialsController@delete');
            });
        });
});

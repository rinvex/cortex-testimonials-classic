<?php

declare(strict_types=1);

Route::domain(domain())->group(function () {
    Route::name('adminarea.')
         ->namespace('Cortex\Testimonials\Http\Controllers\Adminarea')
         ->middleware(['web', 'nohttpcache', 'can:access-adminarea'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/'.config('cortex.foundation.route.prefix.adminarea') : config('cortex.foundation.route.prefix.adminarea'))->group(function () {

        // Testimonials Routes
             Route::name('cortex.testimonials.testimonials.')->prefix('testimonials')->group(function () {
                 Route::match(['get', 'post'], '/')->name('index')->uses('TestimonialsController@index');
                 Route::get('import')->name('import')->uses('TestimonialsController@import');
                 Route::post('import')->name('stash')->uses('TestimonialsController@stash');
                 Route::post('hoard')->name('hoard')->uses('TestimonialsController@hoard');
                 Route::get('import/logs')->name('import.logs')->uses('TestimonialsController@importLogs');
                 Route::get('create')->name('create')->uses('TestimonialsController@create');
                 Route::post('create')->name('store')->uses('TestimonialsController@store');
                 Route::get('{testimonial}')->name('show')->uses('TestimonialsController@show');
                 Route::get('{testimonial}/edit')->name('edit')->uses('TestimonialsController@edit');
                 Route::put('{testimonial}/edit')->name('update')->uses('TestimonialsController@update');
                 Route::get('{testimonial}/logs')->name('logs')->uses('TestimonialsController@logs');
                 Route::delete('{testimonial}')->name('destroy')->uses('TestimonialsController@destroy');
             });
         });
});

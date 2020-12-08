<?php

declare(strict_types=1);

Route::domain('{subdomain}.'.domain())->group(function () {
    Route::name('managerarea.')
         ->namespace('Cortex\Testimonials\Http\Controllers\Managerarea')
         ->middleware(['web', 'nohttpcache', 'can:access-managerarea'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/'.config('cortex.foundation.route.prefix.managerarea') : config('cortex.foundation.route.prefix.managerarea'))->group(function () {

            // Testimonials Routes
             Route::name('cortex.testimonials.testimonials.')->prefix('testimonials')->group(function () {
                 Route::get('/')->name('index')->uses('TestimonialsController@index');
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

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
                 Route::get('import')->name('import')->uses('TestimonialsController@import');
                 Route::post('import')->name('hoard')->uses('TestimonialsController@hoard');
                 Route::get('import/logs')->name('import.logs')->uses('TestimonialsController@importLogs');
                 Route::get('create')->name('create')->uses('TestimonialsController@create');
                 Route::post('create')->name('store')->uses('TestimonialsController@store');
                 Route::get('{testimonial}')->name('edit')->uses('TestimonialsController@edit');
                 Route::put('{testimonial}')->name('update')->uses('TestimonialsController@update');
                 Route::get('{testimonial}/logs')->name('logs')->uses('TestimonialsController@logs');
                 Route::delete('{testimonial}')->name('destroy')->uses('TestimonialsController@destroy');
             });
         });
});

Route::domain('{subdomain}.'.domain())->group(function () {
    Route::name('managerarea.')
         ->namespace('Cortex\Testimonials\Http\Controllers\Managerarea')
         ->middleware(['web', 'nohttpcache', 'can:access-managerarea'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/'.config('cortex.foundation.route.prefix.managerarea') : config('cortex.foundation.route.prefix.managerarea'))->group(function () {

            // Testimonials Routes
             Route::name('testimonials.')->prefix('testimonials')->group(function () {
                 Route::get('/')->name('index')->uses('TestimonialsController@index');
                 Route::get('import')->name('import')->uses('TestimonialsController@import');
                 Route::post('import')->name('hoard')->uses('TestimonialsController@hoard');
                 Route::get('import/logs')->name('import.logs')->uses('TestimonialsController@importLogs');
                 Route::get('create')->name('create')->uses('TestimonialsController@create');
                 Route::post('create')->name('store')->uses('TestimonialsController@store');
                 Route::get('{testimonial}')->name('edit')->uses('TestimonialsController@edit');
                 Route::put('{testimonial}')->name('update')->uses('TestimonialsController@update');
                 Route::get('{testimonial}/logs')->name('logs')->uses('TestimonialsController@logs');
                 Route::delete('{testimonial}')->name('destroy')->uses('TestimonialsController@destroy');
             });
         });
});

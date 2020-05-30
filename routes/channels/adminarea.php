<?php

declare(strict_types=1);

Broadcast::channel('adminarea-testimonials-index', function ($user) {
    return $user->can('list', app('rinvex.testimonials.testimonial'));
}, ['guards' => ['admin']]);

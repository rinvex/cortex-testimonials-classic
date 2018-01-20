<?php

declare(strict_types=1);

namespace Cortex\Testimonials\Policies;

use Rinvex\Fort\Contracts\UserContract;
use Illuminate\Auth\Access\HandlesAuthorization;
use Rinvex\Testimonials\Contracts\TestimonialContract;

class TestimonialPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list testimonials.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Contracts\UserContract $user
     *
     * @return bool
     */
    public function list($ability, UserContract $user): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can create testimonials.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Contracts\UserContract $user
     *
     * @return bool
     */
    public function create($ability, UserContract $user): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can update the testimonial.
     *
     * @param string                                             $ability
     * @param \Rinvex\Fort\Contracts\UserContract                $user
     * @param \Rinvex\Testimonials\Contracts\TestimonialContract $resource
     *
     * @return bool
     */
    public function update($ability, UserContract $user, TestimonialContract $resource): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can update testimonials
    }

    /**
     * Determine whether the user can delete the testimonial.
     *
     * @param string                                             $ability
     * @param \Rinvex\Fort\Contracts\UserContract                $user
     * @param \Rinvex\Testimonials\Contracts\TestimonialContract $resource
     *
     * @return bool
     */
    public function delete($ability, UserContract $user, TestimonialContract $resource): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can delete testimonials
    }
}

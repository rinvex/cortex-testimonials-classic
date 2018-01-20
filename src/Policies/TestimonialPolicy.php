<?php

declare(strict_types=1);

namespace Cortex\Testimonials\Policies;

use Rinvex\Fort\Models\User;
use Rinvex\Testimonials\Models\Testimonial;
use Illuminate\Auth\Access\HandlesAuthorization;

class TestimonialPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list testimonials.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Models\User $user
     *
     * @return bool
     */
    public function list($ability, User $user): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can create testimonials.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Models\User $user
     *
     * @return bool
     */
    public function create($ability, User $user): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can update the testimonial.
     *
     * @param string                                             $ability
     * @param \Rinvex\Fort\Models\User                $user
     * @param \Rinvex\Testimonials\Models\Testimonial $resource
     *
     * @return bool
     */
    public function update($ability, User $user, Testimonial $resource): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can update testimonials
    }

    /**
     * Determine whether the user can delete the testimonial.
     *
     * @param string                                             $ability
     * @param \Rinvex\Fort\Models\User                $user
     * @param \Rinvex\Testimonials\Models\Testimonial $resource
     *
     * @return bool
     */
    public function delete($ability, User $user, Testimonial $resource): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can delete testimonials
    }
}

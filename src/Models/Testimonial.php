<?php

declare(strict_types=1);

namespace Cortex\Testimonials\Models;

use Rinvex\Tenants\Traits\Tenantable;
use Spatie\Activitylog\Traits\LogsActivity;
use Rinvex\Testimonials\Models\Testimonial as BaseTestimonial;

/**
 * Cortex\Testimonials\Models\Testimonial.
 *
 * @property int                                                                             $id
 * @property int                                                                             $user_id
 * @property bool                                                                            $is_approved
 * @property string                                                                          $body
 * @property \Carbon\Carbon|null                                                             $created_at
 * @property \Carbon\Carbon|null                                                             $updated_at
 * @property \Carbon\Carbon|null                                                             $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent                              $user
 * @property \Illuminate\Database\Eloquent\Collection|\Cortex\Tenants\Models\Tenant[]        $tenants
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial approved()
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial disapproved()
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial withAllTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial withAnyTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial withTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial withoutAnyTenants()
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial withoutTenants($tenants, $group = null)
 * @mixin \Eloquent
 */
class Testimonial extends BaseTestimonial
{
    use Tenantable;
    use LogsActivity;

    /**
     * Indicates whether to log only dirty attributes or all.
     *
     * @var bool
     */
    protected static $logOnlyDirty = true;

    /**
     * The attributes that are logged on change.
     *
     * @var array
     */
    protected static $logAttributes = [
        'user_id',
        'is_approved',
        'body',
    ];

    /**
     * The attributes that are ignored on change.
     *
     * @var array
     */
    protected static $ignoreChangedAttributes = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('rinvex.testimonials.tables.testimonials'));
        $this->setRules([
            'user_id' => 'required|integer|exists:'.config('rinvex.fort.tables.users').',id',
            'is_approved' => 'sometimes|boolean',
            'body' => 'required|string|max:150',
        ]);
    }
}

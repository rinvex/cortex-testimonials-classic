<?php

declare(strict_types=1);

namespace Cortex\Testimonials\Models;

use Rinvex\Tenants\Traits\Tenantable;
use Cortex\Foundation\Traits\Auditable;
use Rinvex\Support\Traits\HashidsTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Cortex\Foundation\Events\CrudPerformed;
use Cortex\Foundation\Traits\FiresCustomModelEvent;
use Rinvex\Testimonials\Models\Testimonial as BaseTestimonial;

/**
 * Cortex\Testimonials\Models\Testimonial.
 *
 * @property int                                                                             $id
 * @property int                                                                             $subject_id
 * @property string                                                                          $subject_type
 * @property int                                                                             $attestant_id
 * @property string                                                                          $attestant_type
 * @property bool                                                                            $is_approved
 * @property string                                                                          $body
 * @property \Carbon\Carbon|null                                                             $created_at
 * @property \Carbon\Carbon|null                                                             $updated_at
 * @property \Carbon\Carbon|null                                                             $deleted_at
 * @property-read \Cortex\Auth\Models\User|\Illuminate\Database\Eloquent\Model|\Eloquent     $attestant
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent                              $subject
 * @property \Illuminate\Database\Eloquent\Collection|\Cortex\Tenants\Models\Tenant[]        $tenants
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial approved()
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial disapproved()
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial whereAttestantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial whereAttestantType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial whereSubjectType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial withAllTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial withAnyTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial withTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial withoutAnyTenants()
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Testimonials\Models\Testimonial withoutTenants($tenants, $group = null)
 * @mixin \Eloquent
 */
class Testimonial extends BaseTestimonial
{
    use Auditable;
    use Tenantable;
    use HashidsTrait;
    use LogsActivity;
    use FiresCustomModelEvent;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => CrudPerformed::class,
        'deleted' => CrudPerformed::class,
        'restored' => CrudPerformed::class,
        'updated' => CrudPerformed::class,
    ];

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
    protected static $logFillable = true;

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
}

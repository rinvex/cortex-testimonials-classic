<?php

declare(strict_types=1);

namespace Cortex\Testimonials\Transformers\Adminarea;

use League\Fractal\TransformerAbstract;
use Rinvex\Testimonials\Models\Testimonial;

class TestimonialTransformer extends TransformerAbstract
{
    /**
     * @return array
     */
    public function transform(Testimonial $testimonial): array
    {
        return [
            'id' => (int) $testimonial->getKey(),
            'body' => (string) $testimonial->body,
            'is_approved' => (bool) $testimonial->is_approved,
            'created_at' => (string) $testimonial->created_at,
            'updated_at' => (string) $testimonial->updated_at,
        ];
    }
}

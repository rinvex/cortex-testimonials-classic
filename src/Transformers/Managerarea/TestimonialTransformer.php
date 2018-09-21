<?php

declare(strict_types=1);

namespace Cortex\Testimonials\Transformers\Managerarea;

use Rinvex\Support\Traits\Escaper;
use League\Fractal\TransformerAbstract;
use Cortex\Testimonials\Models\Testimonial;

class TestimonialTransformer extends TransformerAbstract
{
    use Escaper;

    /**
     * @return array
     */
    public function transform(Testimonial $testimonial): array
    {
        return $this->escape([
            'id' => (string) $testimonial->getRouteKey(),
            'created_at' => (string) $testimonial->created_at,
            'updated_at' => (string) $testimonial->updated_at,
        ]);
    }
}

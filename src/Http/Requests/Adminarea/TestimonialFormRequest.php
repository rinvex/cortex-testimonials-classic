<?php

declare(strict_types=1);

namespace Cortex\Testimonials\Http\Requests\Adminarea;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $testimonial = $this->route('testimonial') ?? app('rinvex.testimonials.testimonial');
        $testimonial->updateRulesUniques();

        return $testimonial->getRules();
    }
}

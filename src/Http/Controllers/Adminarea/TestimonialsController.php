<?php

declare(strict_types=1);

namespace Cortex\Testimonials\Http\Controllers\Adminarea;

use Illuminate\Foundation\Http\FormRequest;
use Cortex\Testimonials\Models\Testimonial;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Testimonials\DataTables\Adminarea\TestimonialsDataTable;
use Cortex\Testimonials\Http\Requests\Adminarea\TestimonialFormRequest;

class TestimonialsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = Testimonial::class;

    /**
     * List all testimonials.
     *
     * @param \Cortex\Testimonials\DataTables\Adminarea\TestimonialsDataTable $testimonialsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(TestimonialsDataTable $testimonialsDataTable)
    {
        return $testimonialsDataTable->with([
            'id' => 'adminarea-testimonials-index-table',
            'phrase' => trans('cortex/testimonials::common.testimonials'),
        ])->render('cortex/foundation::adminarea.pages.datatable');
    }

    /**
     * List testimonial logs.
     *
     * @param \Cortex\Testimonials\Models\Testimonial     $testimonial
     * @param \Cortex\Foundation\DataTables\LogsDataTable $logsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function logs(Testimonial $testimonial, LogsDataTable $logsDataTable)
    {
        return $logsDataTable->with([
            'resource' => $testimonial,
            'tabs' => 'adminarea.testimonials.tabs',
            'phrase' => trans('cortex/testimonials::common.testimonials'),
            'id' => "adminarea-testimonials-{$testimonial->getKey()}-logs-table",
        ])->render('cortex/foundation::adminarea.pages.datatable-logs');
    }

    /**
     * Create new testimonial.
     *
     * @param \Cortex\Testimonials\Models\Testimonial $testimonial
     *
     * @return \Illuminate\View\View
     */
    public function create(Testimonial $testimonial)
    {
        return $this->form($testimonial);
    }

    /**
     * Edit given testimonial.
     *
     * @param \Cortex\Testimonials\Models\Testimonial $testimonial
     *
     * @return \Illuminate\View\View
     */
    public function edit(Testimonial $testimonial)
    {
        return $this->form($testimonial);
    }

    /**
     * Show testimonial create/edit form.
     *
     * @param \Cortex\Testimonials\Models\Testimonial $testimonial
     *
     * @return \Illuminate\View\View
     */
    protected function form(Testimonial $testimonial)
    {
        return view('cortex/testimonials::adminarea.pages.testimonial', compact('testimonial'));
    }

    /**
     * Store new testimonial.
     *
     * @param \Cortex\Testimonials\Http\Requests\Adminarea\TestimonialFormRequest $request
     * @param \Cortex\Testimonials\Models\Testimonial                             $testimonial
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(TestimonialFormRequest $request, Testimonial $testimonial)
    {
        return $this->process($request, $testimonial);
    }

    /**
     * Update given testimonial.
     *
     * @param \Cortex\Testimonials\Http\Requests\Adminarea\TestimonialFormRequest $request
     * @param \Cortex\Testimonials\Models\Testimonial                             $testimonial
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(TestimonialFormRequest $request, Testimonial $testimonial)
    {
        return $this->process($request, $testimonial);
    }

    /**
     * Process stored/updated testimonial.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Cortex\Testimonials\Models\Testimonial $testimonial
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function process(FormRequest $request, Testimonial $testimonial)
    {
        // Prepare required input fields
        $data = $request->validated();

        // Save testimonial
        $testimonial->fill($data)->save();

        return intend([
            'url' => route('adminarea.testimonials.index'),
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => 'testimonial', 'id' => $testimonial->getKey()])],
        ]);
    }

    /**
     * Destroy given testimonial.
     *
     * @param \Cortex\Testimonials\Models\Testimonial $testimonial
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return intend([
            'url' => route('adminarea.testimonials.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => 'testimonial', 'id' => $testimonial->getKey()])],
        ]);
    }
}

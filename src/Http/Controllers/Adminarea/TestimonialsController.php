<?php

declare(strict_types=1);

namespace Cortex\Testimonials\Http\Controllers\Adminarea;

use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Rinvex\Testimonials\Contracts\TestimonialContract;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Testimonials\DataTables\Adminarea\TestimonialsDataTable;
use Cortex\Testimonials\Http\Requests\Adminarea\TestimonialFormRequest;

class TestimonialsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'testimonials';

    /**
     * Display a listing of the resource.
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
     * Get a listing of the resource logs.
     *
     * @param \Rinvex\Testimonials\Contracts\TestimonialContract $testimonial
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logs(TestimonialContract $testimonial)
    {
        return request()->ajax() && request()->wantsJson()
            ? app(LogsDataTable::class)->with(['resource' => $testimonial])->ajax()
            : intend(['url' => route('adminarea.testimonials.edit', ['testimonial' => $testimonial]).'#logs-tab']);
    }

    /**
     * Show the form for create/update of the given resource.
     *
     * @param \Rinvex\Testimonials\Contracts\TestimonialContract $testimonial
     *
     * @return \Illuminate\Http\Response
     */
    public function form(TestimonialContract $testimonial)
    {
        $logs = app(LogsDataTable::class)->with(['id' => "adminarea-testimonials-{$testimonial->getKey()}-logs-table"])->html()->minifiedAjax(route('adminarea.testimonials.logs', ['testimonial' => $testimonial]));

        return view('cortex/testimonials::adminarea.pages.testimonial', compact('testimonial', 'logs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Cortex\Testimonials\Http\Requests\Adminarea\TestimonialFormRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TestimonialFormRequest $request)
    {
        return $this->process($request, app('rinvex.testimonials.testimonial'));
    }

    /**
     * Update the given resource in storage.
     *
     * @param \Cortex\Testimonials\Http\Requests\Adminarea\TestimonialFormRequest $request
     * @param \Rinvex\Testimonials\Contracts\TestimonialContract                  $testimonial
     *
     * @return \Illuminate\Http\Response
     */
    public function update(TestimonialFormRequest $request, TestimonialContract $testimonial)
    {
        return $this->process($request, $testimonial);
    }

    /**
     * Process the form for store/update of the given resource.
     *
     * @param \Illuminate\Foundation\Http\FormRequest            $request
     * @param \Rinvex\Testimonials\Contracts\TestimonialContract $testimonial
     *
     * @return \Illuminate\Http\Response
     */
    protected function process(FormRequest $request, TestimonialContract $testimonial)
    {
        // Prepare required input fields
        $data = $request->validated();

        // Save testimonial
        $testimonial->fill($data)->save();

        return intend([
            'url' => route('adminarea.testimonials.index'),
            'with' => ['success' => trans('cortex/testimonials::messages.testimonial.saved', ['id' => $testimonial->getKey()])],
        ]);
    }

    /**
     * Delete the given resource from storage.
     *
     * @param \Rinvex\Testimonials\Contracts\TestimonialContract $testimonial
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(TestimonialContract $testimonial)
    {
        $testimonial->delete();

        return intend([
            'url' => route('adminarea.testimonials.index'),
            'with' => ['warning' => trans('cortex/testimonials::messages.testimonial.deleted', ['id' => $testimonial->getKey()])],
        ]);
    }
}

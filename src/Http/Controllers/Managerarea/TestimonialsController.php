<?php

declare(strict_types=1);

namespace Cortex\Testimonials\Http\Controllers\Managerarea;

use Illuminate\Http\Request;
use Cortex\Foundation\DataTables\LogsDataTable;
use Rinvex\Testimonials\Contracts\TestimonialContract;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Testimonials\DataTables\Managerarea\TestimonialsDataTable;
use Cortex\Testimonials\Http\Requests\Managerarea\TestimonialFormRequest;

class TestimonialsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'testimonials';

    /**
     * Display a listing of the resource.
     *
     * @param \Cortex\Testimonials\DataTables\Managerarea\TestimonialsDataTable $testimonialsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(TestimonialsDataTable $testimonialsDataTable)
    {
        return $testimonialsDataTable->with([
            'id' => 'cortex-testimonials',
            'phrase' => trans('cortex/testimonials::common.testimonials'),
        ])->render('cortex/tenants::managerarea.pages.datatable');
    }

    /**
     * Display a listing of the resource logs.
     *
     * @param \Rinvex\Testimonials\Contracts\TestimonialContract  $category
     * @param \Cortex\Foundation\DataTables\LogsDataTable $logsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function logs(TestimonialContract $testimonial, LogsDataTable $logsDataTable)
    {
        return $logsDataTable->with([
            'tab' => 'logs',
            'type' => 'testimonials',
            'resource' => $testimonial,
            'id' => 'cortex-testimonials-logs',
            'phrase' => trans('cortex/testimonials::common.testimonials'),
            'title' => trans('cortex/testimonials::common.user_testimonial', ['user' => $testimonial->user->username, 'id' => $testimonial->id]),
        ])->render('cortex/tenants::managerarea.pages.datatable-tab');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Cortex\Testimonials\Http\Requests\Managerarea\TestimonialFormRequest $request
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
     * @param \Cortex\Testimonials\Http\Requests\Managerarea\TestimonialFormRequest $request
     * @param \Rinvex\Testimonials\Contracts\TestimonialContract                  $testimonial
     *
     * @return \Illuminate\Http\Response
     */
    public function update(TestimonialFormRequest $request, TestimonialContract $testimonial)
    {
        return $this->process($request, $testimonial);
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
            'url' => route('managerarea.testimonials.index'),
            'with' => ['warning' => trans('cortex/testimonials::messages.testimonial.deleted', ['id' => $testimonial->id])],
        ]);
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
        $users = app('rinvex.fort.user')->all()->pluck('username', 'id');

        return view('cortex/testimonials::managerarea.pages.testimonial', compact('testimonial', 'users'));
    }

    /**
     * Process the form for store/update of the given resource.
     *
     * @param \Illuminate\Http\Request                   $request
     * @param \Rinvex\Testimonials\Contracts\TestimonialContract $testimonial
     *
     * @return \Illuminate\Http\Response
     */
    protected function process(Request $request, TestimonialContract $testimonial)
    {
        // Prepare required input fields
        $data = $request->all();

        // Save testimonial
        $testimonial->fill($data)->save();

        return intend([
            'url' => route('managerarea.testimonials.index'),
            'with' => ['success' => trans('cortex/testimonials::messages.testimonial.saved', ['id' => $testimonial->id])],
        ]);
    }
}

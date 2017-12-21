<?php

declare(strict_types=1);

namespace Cortex\Testimonials\DataTables\Adminarea;

use Cortex\Foundation\DataTables\AbstractDataTable;
use Rinvex\Testimonials\Contracts\TestimonialContract;
use Cortex\Testimonials\Transformers\Adminarea\TestimonialTransformer;

class TestimonialsDataTable extends AbstractDataTable
{
    /**
     * {@inheritdoc}
     */
    protected $model = TestimonialContract::class;

    /**
     * {@inheritdoc}
     */
    protected $transformer = TestimonialTransformer::class;

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = app($this->model)->query()->with(['user']);

        return $this->applyScopes($query);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $link = config('cortex.foundation.route.locale_prefix')
            ? '"<a href=\""+routes.route(\'adminarea.testimonials.edit\', {testimonial: full.id, locale: \''.$this->request->segment(1).'\'})+"\">"+data+"</a>"'
            : '"<a href=\""+routes.route(\'adminarea.testimonials.edit\', {testimonial: full.id})+"\">"+data+"</a>"';

        return [
            'body' => ['title' => trans('cortex/testimonials::common.body'), 'render' => $link.'+(full.is_approved ? " <i class=\"text-success fa fa-check\"></i>" : " <i class=\"text-danger fa fa-close\"></i>")', 'responsivePriority' => 0],
            'user.username' => ['title' => trans('cortex/testimonials::common.user')],
            'created_at' => ['title' => trans('cortex/testimonials::common.created_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
            'updated_at' => ['title' => trans('cortex/testimonials::common.updated_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
        ];
    }
}

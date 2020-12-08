<?php

declare(strict_types=1);

namespace Cortex\Testimonials\Http\Controllers\Managerarea;

use Exception;
use Illuminate\Http\Request;
use Cortex\Testimonials\Models\Testimonial;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\Importers\DefaultImporter;
use Cortex\Foundation\DataTables\ImportLogsDataTable;
use Cortex\Foundation\Http\Requests\ImportFormRequest;
use Cortex\Foundation\DataTables\ImportRecordsDataTable;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Testimonials\DataTables\Managerarea\TestimonialsDataTable;
use Cortex\Testimonials\Http\Requests\Managerarea\TestimonialFormRequest;

class TestimonialsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = Testimonial::class;

    /**
     * List all testimonials.
     *
     * @param \Cortex\Testimonials\DataTables\Managerarea\TestimonialsDataTable $testimonialsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(TestimonialsDataTable $testimonialsDataTable)
    {
        return $testimonialsDataTable->with([
            'id' => 'managerarea-cortex-testimonials-testimonials-index',
            'pusher' => ['entity' => 'testimonial', 'channel' => 'rinvex.testimonials.testimonials.index'],
        ])->render('cortex/foundation::managerarea.pages.datatable-index');
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
            'tabs' => 'managerarea.cortex.testimonials.testimonials.tabs',
            'id' => "managerarea-cortex-testimonials-testimonials-{$testimonial->getRouteKey()}-logs",
        ])->render('cortex/foundation::managerarea.pages.datatable-tab');
    }

    /**
     * Import testimonials.
     *
     * @param \Cortex\Testimonials\Models\Testimonial              $testimonial
     * @param \Cortex\Foundation\DataTables\ImportRecordsDataTable $importRecordsDataTable
     *
     * @return \Illuminate\View\View
     */
    public function import(Testimonial $testimonial, ImportRecordsDataTable $importRecordsDataTable)
    {
        return $importRecordsDataTable->with([
            'resource' => $testimonial,
            'tabs' => 'managerarea.cortex.testimonials.testimonials.tabs',
            'url' => route('managerarea.cortex.testimonials.testimonials.stash'),
            'id' => "managerarea-cortex-testimonials-testimonials-{$testimonial->getRouteKey()}-import",
        ])->render('cortex/foundation::managerarea.pages.datatable-dropzone');
    }

    /**
     * Stash testimonials.
     *
     * @param \Cortex\Foundation\Http\Requests\ImportFormRequest $request
     * @param \Cortex\Foundation\Importers\DefaultImporter       $importer
     *
     * @return void
     */
    public function stash(ImportFormRequest $request, DefaultImporter $importer)
    {
        // Handle the import
        $importer->config['resource'] = $this->resource;
        $importer->config['name'] = 'id';
        $importer->handleImport();
    }

    /**
     * Hoard testimonials.
     *
     * @param \Cortex\Foundation\Http\Requests\ImportFormRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function hoard(ImportFormRequest $request)
    {
        foreach ((array) $request->get('selected_ids') as $recordId) {
            $record = app('cortex.foundation.import_record')->find($recordId);

            try {
                $fillable = collect($record['data'])->intersectByKeys(array_flip(app('rinvex.testimonials.testimonial')->getFillable()))->toArray();

                tap(app('rinvex.testimonials.testimonial')->firstOrNew($fillable), function ($instance) use ($record) {
                    $instance->save() && $record->delete();
                });
            } catch (Exception $exception) {
                $record->notes = $exception->getMessage().(method_exists($exception, 'getMessageBag') ? "\n".json_encode($exception->getMessageBag())."\n\n" : '');
                $record->status = 'fail';
                $record->save();
            }
        }

        return intend([
            'back' => true,
            'with' => ['success' => trans('cortex/foundation::messages.import_complete')],
        ]);
    }

    /**
     * List testimonial import logs.
     *
     * @param \Cortex\Foundation\DataTables\ImportLogsDataTable $importLogsDatatable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function importLogs(ImportLogsDataTable $importLogsDatatable)
    {
        return $importLogsDatatable->with([
            'resource' => trans('cortex/testimonials::common.testimonial'),
            'tabs' => 'managerarea.cortex.testimonials.testimonials.tabs',
            'id' => 'managerarea-cortex-testimonials-testimonials-import-logs',
        ])->render('cortex/foundation::managerarea.pages.datatable-tab');
    }

    /**
     * Create new testimonial.
     *
     * @param \Illuminate\Http\Request                $request
     * @param \Cortex\Testimonials\Models\Testimonial $testimonial
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request, Testimonial $testimonial)
    {
        return $this->form($request, $testimonial);
    }

    /**
     * Edit given testimonial.
     *
     * @param \Illuminate\Http\Request                $request
     * @param \Cortex\Testimonials\Models\Testimonial $testimonial
     *
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, Testimonial $testimonial)
    {
        return $this->form($request, $testimonial);
    }

    /**
     * Show testimonial create/edit form.
     *
     * @param \Illuminate\Http\Request                $request
     * @param \Cortex\Testimonials\Models\Testimonial $testimonial
     *
     * @return \Illuminate\View\View
     */
    protected function form(Request $request, Testimonial $testimonial)
    {
        return view('cortex/testimonials::managerarea.pages.testimonial', compact('testimonial'));
    }

    /**
     * Store new testimonial.
     *
     * @param \Cortex\Testimonials\Http\Requests\Managerarea\TestimonialFormRequest $request
     * @param \Cortex\Testimonials\Models\Testimonial                               $testimonial
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
     * @param \Cortex\Testimonials\Http\Requests\Managerarea\TestimonialFormRequest $request
     * @param \Cortex\Testimonials\Models\Testimonial                               $testimonial
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
            'url' => route('managerarea.cortex.testimonials.testimonials.index'),
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => trans('cortex/testimonials::common.testimonial'), 'identifier' => $testimonial->getRouteKey()])],
        ]);
    }

    /**
     * Destroy given testimonial.
     *
     * @param \Cortex\Testimonials\Models\Testimonial $testimonial
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return intend([
            'url' => route('managerarea.cortex.testimonials.testimonials.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => trans('cortex/testimonials::common.testimonial'), 'identifier' => $testimonial->getRouteKey()])],
        ]);
    }
}

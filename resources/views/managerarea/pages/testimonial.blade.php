{{-- Master Layout --}}
@extends('cortex/foundation::managerarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ extract_title(Breadcrumbs::render()) }}
@endsection

@push('inline-scripts')
    {!! JsValidator::formRequest(Cortex\Testimonials\Http\Requests\Managerarea\TestimonialFormRequest::class)->selector("#managerarea-cortex-testimonials-testimonials-create-form, #managerarea-cortex-testimonials-testimonials-{$testimonial->getRouteKey()}-update-form")->ignore('.skip-validation') !!}
@endpush

{{-- Main Content --}}
@section('content')

    @includeWhen($testimonial->exists, 'cortex/foundation::managerarea.partials.modal', ['id' => 'delete-confirmation'])

    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{ Breadcrumbs::render() }}</h1>
        </section>

        {{-- Main content --}}
        <section class="content">

            <div class="nav-tabs-custom">
                @includeWhen($testimonial->exists, 'cortex/foundation::managerarea.partials.actions', ['name' => 'testimonial', 'model' => $testimonial, 'resource' => trans('cortex/testimonials::common.testimonial'), 'routePrefix' => 'managerarea.cortex.testimonials.testimonials.'])
                {!! Menu::render('managerarea.cortex.testimonials.testimonials.tabs', 'nav-tab') !!}

                <div class="tab-content">

                    <div class="tab-pane active" id="details-tab">

                        @if ($testimonial->exists)
                            {{ Form::model($testimonial, ['url' => route('managerarea.cortex.testimonials.testimonials.update', ['testimonial' => $testimonial]), 'method' => 'put', 'id' => "managerarea-cortex-testimonials-testimonials-{$testimonial->getRouteKey()}-update-form"]) }}
                        @else
                            {{ Form::model($testimonial, ['url' => route('managerarea.cortex.testimonials.testimonials.store'), 'id' => 'managerarea-cortex-testimonials-testimonials-create-form']) }}
                        @endif

                            <div class="row">

                                <div class="col-md-12">

                                    {{-- Body --}}
                                    <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                        {{ Form::label('body', trans('cortex/testimonials::common.body'), ['class' => 'control-label']) }}
                                        {{ Form::text('body', null, ['class' => 'form-control', 'placeholder' => trans('cortex/testimonials::common.body')]) }}

                                        @if ($errors->has('body'))
                                            <span class="help-block">{{ $errors->first('body') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Approved --}}
                                    <div class="form-group{{ $errors->has('is_approved') ? ' has-error' : '' }}">
                                        {{ Form::label('is_approved', trans('cortex/testimonials::common.approved'), ['class' => 'control-label']) }}
                                        {{ Form::select('is_approved', [0 => trans('cortex/testimonials::common.no'), 1 => trans('cortex/testimonials::common.yes')], null, ['class' => 'form-control select2', 'data-minimum-results-for-search' => 'Infinity', 'data-width' => '100%']) }}

                                        @if ($errors->has('is_approved'))
                                            <span class="help-block">{{ $errors->first('is_approved') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="pull-right">
                                        {{ Form::button(trans('cortex/testimonials::common.submit'), ['class' => 'btn btn-primary btn-flat', 'type' => 'submit']) }}
                                    </div>

                                    @include('cortex/foundation::managerarea.partials.timestamps', ['model' => $testimonial])

                                </div>

                            </div>

                        {{ Form::close() }}

                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection

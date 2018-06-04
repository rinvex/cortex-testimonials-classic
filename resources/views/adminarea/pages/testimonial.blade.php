{{-- Master Layout --}}
@extends('cortex/foundation::adminarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ extract_title(Breadcrumbs::render()) }}
@endsection

@push('inline-scripts')
    {!! JsValidator::formRequest(Cortex\Testimonials\Http\Requests\Adminarea\TestimonialFormRequest::class)->selector("#adminarea-testimonials-create-form, #adminarea-testimonials-{$testimonial->getRouteKey()}-update-form") !!}
@endpush

{{-- Main Content --}}
@section('content')

    @if($testimonial->exists)
        @include('cortex/foundation::common.partials.modal', ['id' => 'delete-confirmation'])
    @endif

    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{ Breadcrumbs::render() }}</h1>
        </section>

        {{-- Main content --}}
        <section class="content">

            <div class="nav-tabs-custom">
                @if($testimonial->exists && $currentUser->can('delete', $testimonial))
                    <div class="pull-right">
                        <a href="#" data-toggle="modal" data-target="#delete-confirmation"
                           data-modal-action="{{ route('adminarea.testimonials.destroy', ['testimonial' => $testimonial]) }}"
                           data-modal-title="{!! trans('cortex/foundation::messages.delete_confirmation_title') !!}"
                           data-modal-button="<a href='#' class='btn btn-danger' data-form='delete' data-token='{{ csrf_token() }}'><i class='fa fa-trash-o'></i> {{ trans('cortex/foundation::common.delete') }}</a>"
                           data-modal-body="{!! trans('cortex/foundation::messages.delete_confirmation_body', ['resource' => trans('cortex/testimonials::common.testimonial'), 'identifier' => $testimonial->getRouteKey()]) !!}"
                           title="{{ trans('cortex/foundation::common.delete') }}" class="btn btn-default" style="margin: 4px"><i class="fa fa-trash text-danger"></i>
                        </a>
                    </div>
                @endif
                {!! Menu::render('adminarea.testimonials.tabs', 'nav-tab') !!}

                <div class="tab-content">

                    <div class="tab-pane active" id="details-tab">

                        @if ($testimonial->exists)
                            {{ Form::model($testimonial, ['url' => route('adminarea.testimonials.update', ['testimonial' => $testimonial]), 'method' => 'put', 'id' => "adminarea-testimonials-{$testimonial->getRouteKey()}-update-form"]) }}
                        @else
                            {{ Form::model($testimonial, ['url' => route('adminarea.testimonials.store'), 'id' => 'adminarea-testimonials-create-form']) }}
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

                                    @include('cortex/foundation::adminarea.partials.timestamps', ['model' => $testimonial])

                                </div>

                            </div>

                        {{ Form::close() }}

                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection

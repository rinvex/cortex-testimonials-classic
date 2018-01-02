{{-- Master Layout --}}
@extends('cortex/tenants::managerarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ config('app.name') }} » {{ trans('cortex/foundation::common.managerarea') }} » {{ trans('cortex/testimonials::common.testimonials') }} » {{ $testimonial->exists ? $testimonial->name : trans('cortex/testimonials::common.create_testimonial') }}
@stop

@push('scripts')
    {!! JsValidator::formRequest(Cortex\Testimonials\Http\Requests\Managerarea\TestimonialFormRequest::class)->selector('#managerarea-testimonials-save') !!}
@endpush

{{-- Main Content --}}
@section('content')

    @if($testimonial->exists)
        @include('cortex/foundation::common.partials.confirm-deletion', ['type' => 'testimonial'])
    @endif

    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{ Breadcrumbs::render() }}</h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#details-tab" data-toggle="tab">{{ trans('cortex/testimonials::common.details') }}</a></li>
                    @if($testimonial->exists) <li><a href="#logs-tab" data-toggle="tab">{{ trans('cortex/testimonials::common.logs') }}</a></li> @endif
                    @if($testimonial->exists && $currentUser->can('delete-testimonials', $testimonial)) <li class="pull-right"><a href="#" data-toggle="modal" data-target="#delete-confirmation" data-item-href="{{ route('managerarea.testimonials.delete', ['testimonial' => $testimonial]) }}" data-item-name="{{ str_slug($testimonial->name) }}"><i class="fa fa-trash text-danger"></i></a></li> @endif
                </ul>

                <div class="tab-content">

                    <div class="tab-pane active" id="details-tab">

                        @if ($testimonial->exists)
                            {{ Form::model($testimonial, ['url' => route('managerarea.testimonials.update', ['testimonial' => $testimonial]), 'method' => 'put', 'id' => 'managerarea-testimonials-save']) }}
                        @else
                            {{ Form::model($testimonial, ['url' => route('managerarea.testimonials.store'), 'id' => 'managerarea-testimonials-save']) }}
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

                                    {{-- User --}}
                                    <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                                        {{ Form::label('user_id', trans('cortex/testimonials::common.user'), ['class' => 'control-label']) }}
                                        {{ Form::hidden('user_id', '') }}
                                        {{ Form::select('user_id', $users, null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/testimonials::common.select_user'), 'data-allow-clear' => 'true', 'data-width' => '100%']) }}

                                        @if ($errors->has('user_id'))
                                            <span class="help-block">{{ $errors->first('user_id') }}</span>
                                        @endif
                                    </div>

                                </div>

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

                                    @include('cortex/tenants::managerarea.partials.timestamps', ['model' => $testimonial])

                                </div>

                            </div>

                        {{ Form::close() }}

                    </div>

                    @if($testimonial->exists)

                        <div class="tab-pane" id="logs-tab">
                            {!! $logs->table(['class' => 'table table-striped table-hover responsive dataTableBuilder', 'id' => 'logs-table']) !!}
                        </div>

                    @endif

                </div>

            </div>

        </section>

    </div>

@endsection

@if($testimonial->exists)

    @push('styles')
        <link href="{{ mix('css/datatables.css', 'assets') }}" rel="stylesheet">
    @endpush

    @push('scripts-vendor')
        <script src="{{ mix('js/datatables.js', 'assets') }}" type="text/javascript"></script>
    @endpush

    @push('scripts')
        {!! $logs->scripts() !!}
    @endpush

@endif

{{-- Master Layout --}}
@extends('cortex/foundation::adminarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ config('app.name') }} » {{ trans('cortex/foundation::common.adminarea') }} » {{ trans('cortex/testimonials::common.testimonials') }} » {{ $testimonial->exists ? $testimonial->name : trans('cortex/testimonials::common.create_testimonial') }}
@stop

@push('scripts')
    {!! JsValidator::formRequest(Cortex\Testimonials\Http\Requests\Adminarea\TestimonialFormRequest::class)->selector('#adminarea-testimonials-save') !!}
@endpush

{{-- Main Content --}}
@section('content')

    @if($testimonial->exists)
        @include('cortex/foundation::common.partials.confirm-deletion', ['type' => 'testimonial'])
    @endif

    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{ $testimonial->exists ? trans('cortex/testimonials::common.user_testimonial', ['user' => $testimonial->user->username, 'id' => $testimonial->id]) : trans('cortex/testimonials::common.create_testimonial') }}</h1>
            <!-- Breadcrumbs -->
            {{ Breadcrumbs::render() }}
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#details-tab" data-toggle="tab">{{ trans('cortex/testimonials::common.details') }}</a></li>
                    @if($testimonial->exists) <li><a href="{{ route('adminarea.testimonials.logs', ['testimonial' => $testimonial]) }}">{{ trans('cortex/testimonials::common.logs') }}</a></li> @endif
                    @if($testimonial->exists && $currentUser->can('delete-testimonials', $testimonial)) <li class="pull-right"><a href="#" data-toggle="modal" data-target="#delete-confirmation" data-item-href="{{ route('adminarea.testimonials.delete', ['testimonial' => $testimonial]) }}" data-item-name="{{ str_slug($testimonial->name) }}"><i class="fa fa-trash text-danger"></i></a></li> @endif
                </ul>

                <div class="tab-content">

                    <div class="tab-pane active" id="details-tab">

                        @if ($testimonial->exists)
                            {{ Form::model($testimonial, ['url' => route('adminarea.testimonials.update', ['testimonial' => $testimonial]), 'method' => 'put', 'id' => 'adminarea-testimonials-save']) }}
                        @else
                            {{ Form::model($testimonial, ['url' => route('adminarea.testimonials.store'), 'id' => 'adminarea-testimonials-save']) }}
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

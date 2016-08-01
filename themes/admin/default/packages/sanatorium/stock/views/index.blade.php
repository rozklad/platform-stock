@extends('layouts/default')

{{-- Page title --}}
@section('title')
    @parent
    {{ trans('sanatorium/stock::common.title') }}
@stop

{{-- Inline scripts --}}
@section('scripts')
    @parent
@stop

{{-- Inline styles --}}
@section('styles')
    @parent
@stop

{{-- Page content --}}
@section('page')

    {{-- Grid --}}
    <section class="panel panel-default panel-grid">

        {{-- Grid: Header --}}
        <header class="panel-heading">

            <nav class="navbar navbar-default navbar-actions">

                <div class="container-fluid">

                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#actions">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <span class="navbar-brand">{{{ trans('sanatorium/stock::common.title') }}}</span>

                    </div>

                </div>

            </nav>

        </header>

        <div class="panel-body">

            <div class="row">
                <div class="col-sm-6 text-center">
                    <h3>
                        {{ trans('sanatorium/stock::common.action.minimal') }}
                    </h3>
                    <p>
                        {{ trans('sanatorium/stock::common.action.minimal_desc') }}
                    </p>
                    <a href="{{ route('admin.sanatorium.stock.action', ['type' => 'minimal']) }}" class="btn btn-primary">
                        {{ trans('sanatorium/stock::common.action.minimal_action') }}
                    </a>
                    <br>
                </div>
                <div class="col-sm-6 text-center">
                    <h3>
                        {{ trans('sanatorium/stock::common.action.not_available') }}
                    </h3>
                    <p>
                        {{ trans('sanatorium/stock::common.action.not_available_desc') }}
                    </p>
                    <a href="{{ route('admin.sanatorium.stock.action', ['type' => 'not_available']) }}" class="btn btn-primary">
                        {{ trans('sanatorium/stock::common.action.not_available_action') }}
                    </a>
                    <br>
                </div>
            </div>

        </div>


    </section>


@stop

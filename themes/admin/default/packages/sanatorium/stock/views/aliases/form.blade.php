@extends('layouts/default')

{{-- Page title --}}
@section('title')
@parent
{{{ trans("action.{$mode}") }}} {{ trans('sanatorium/stock::aliases/common.title') }}
@stop

{{-- Queue assets --}}
{{ Asset::queue('validate', 'platform/js/validate.js', 'jquery') }}
{{ Asset::queue('selectize', 'selectize/js/selectize.js', 'jquery') }}
{{ Asset::queue('selectize', 'selectize/css/selectize.bootstrap3.css') }}

{{-- Inline scripts --}}
@section('scripts')
@parent
<script type="text/javascript">
	$(function(){
		$('#usage').selectize({
			persist: false,
			maxItems: 1,
			create: false,
			allowEmptyOption: false,
			valueField: 'slug',
			labelField: 'name',
			searchField: ['name'],
			sortField: [
				{field: 'name', direction: 'asc'}
			],
			items: [
				'{{ $alias->usage ? $alias->usage : 'default' }}'
			],
			options: [
				@foreach( $usages as $usage_class )
					<?php $usage = new $usage_class; ?>
					{ name: '{{ $usage->name }}', slug: '{{ $usage->slug }}', description: '{{ $usage->description }}' },
				@endforeach
			],
			render: {
				item: function(item, escape) {
					return '<div>' +
						(item.name ? '<strong class="name">' + item.name + '</strong><br>' : '') +
						(item.description ? '<span class="description">' + item.description + '</span>' : '') +
					'</div>';
				},
				option: function(item, escape) {
					return '<div>' +
						(item.name ? '<strong class="name">' + item.name + '</strong><br>' : '') +
						(item.description ? '<span class="description">' + item.description + '</span>' : '') +
					'</div>';
				}
			}
		});
	});
</script>
@stop

{{-- Inline styles --}}
@section('styles')
@parent
@stop

{{-- Page content --}}
@section('page')

<section class="panel panel-default panel-tabs">

	{{-- Form --}}
	<form id="stock-form" action="{{ request()->fullUrl() }}" role="form" method="post" data-parsley-validate>

		{{-- Form: CSRF Token --}}
		<input type="hidden" name="_token" value="{{ csrf_token() }}">

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

						<a class="btn btn-navbar-cancel navbar-btn pull-left tip" href="{{ route('admin.sanatorium.stock.aliases.all') }}" data-toggle="tooltip" data-original-title="{{{ trans('action.cancel') }}}">
							<i class="fa fa-reply"></i> <span class="visible-xs-inline">{{{ trans('action.cancel') }}}</span>
						</a>

						<span class="navbar-brand">{{{ trans("action.{$mode}") }}} <small>{{{ $alias->exists ? $alias->id : null }}}</small></span>
					</div>

					{{-- Form: Actions --}}
					<div class="collapse navbar-collapse" id="actions">

						<ul class="nav navbar-nav navbar-right">

							@if ($alias->exists)
							<li>
								<a href="{{ route('admin.sanatorium.stock.aliases.delete', $alias->id) }}" class="tip" data-action-delete data-toggle="tooltip" data-original-title="{{{ trans('action.delete') }}}" type="delete">
									<i class="fa fa-trash-o"></i> <span class="visible-xs-inline">{{{ trans('action.delete') }}}</span>
								</a>
							</li>
							@endif

							<li>
								<button class="btn btn-primary navbar-btn" data-toggle="tooltip" data-original-title="{{{ trans('action.save') }}}">
									<i class="fa fa-save"></i> <span class="visible-xs-inline">{{{ trans('action.save') }}}</span>
								</button>
							</li>

						</ul>

					</div>

				</div>

			</nav>

		</header>

		<div class="panel-body">

			<div role="tabpanel">

				{{-- Form: Tabs --}}
				<ul class="nav nav-tabs" role="tablist">
					<li class="active" role="presentation"><a href="#general-tab" aria-controls="general-tab" role="tab" data-toggle="tab">{{{ trans('sanatorium/stock::aliases/common.tabs.general') }}}</a></li>
					<li role="presentation"><a href="#attributes" aria-controls="attributes" role="tab" data-toggle="tab">{{{ trans('sanatorium/stock::aliases/common.tabs.attributes') }}}</a></li>
				</ul>

				<div class="tab-content">

					{{-- Tab: General --}}
					<div role="tabpanel" class="tab-pane fade in active" id="general-tab">

						<fieldset>

							<div class="row">

								<div class="form-group{{ Alert::onForm('usage', ' has-error') }}">

									<label for="usage" class="control-label">
										<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('sanatorium/stock::aliases/model.general.usage_help') }}}"></i>
										{{{ trans('sanatorium/stock::aliases/model.general.usage') }}}
									</label>

									<select name="usage" class="usage" id="usage"></select>

									<span class="help-block">{{{ Alert::onForm('usage') }}}</span>

								</div>
							
							</div>

							<div class="row">

								<div class="col-sm-6">

									<div class="form-group{{ Alert::onForm('min', ' has-error') }}">

										<label for="min" class="control-label">
											<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('sanatorium/stock::aliases/model.general.min_help') }}}"></i>
											{{{ trans('sanatorium/stock::aliases/model.general.min') }}}
										</label>

										<input type="text" class="form-control" name="min" id="min" placeholder="{{{ trans('sanatorium/stock::aliases/model.general.min') }}}" value="{{{ input()->old('min', $alias->min) }}}">

										<span class="help-block">{{{ Alert::onForm('min') }}}</span>

									</div>

								</div>

								<div class="col-sm-6">

									<div class="form-group{{ Alert::onForm('max', ' has-error') }}">

										<label for="max" class="control-label">
											<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('sanatorium/stock::aliases/model.general.max_help') }}}"></i>
											{{{ trans('sanatorium/stock::aliases/model.general.max') }}}
										</label>

										<input type="text" class="form-control" name="max" id="max" placeholder="{{{ trans('sanatorium/stock::aliases/model.general.max') }}}" value="{{{ input()->old('max', $alias->max) }}}">

										<span class="help-block">{{{ Alert::onForm('max') }}}</span>

									</div>

								</div>

							</div>

							<div class="row">

								<div class="form-group{{ Alert::onForm('alias', ' has-error') }}">

									<label for="alias" class="control-label">
										<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('sanatorium/stock::aliases/model.general.alias_help') }}}"></i>
										{{{ trans('sanatorium/stock::aliases/model.general.alias') }}}
									</label>

									<input type="text" class="form-control" name="alias" id="alias" placeholder="{{{ trans('sanatorium/stock::aliases/model.general.alias') }}}" value="{{{ input()->old('alias', $alias->alias) }}}">

									<span class="help-block">{{{ Alert::onForm('alias') }}}</span>

								</div>

								<div class="form-group{{ Alert::onForm('product_id', ' has-error') }}">

									<input type="hidden" class="form-control" name="product_id" id="product_id" placeholder="{{{ trans('sanatorium/stock::aliases/model.general.product_id') }}}" value="*">

								</div>

								<div class="form-group{{ Alert::onForm('available', ' has-error') }}">

									<label for="available" class="control-label">
										<i class="fa fa-info-circle" data-toggle="popover" data-content="{{{ trans('sanatorium/stock::aliases/model.general.available_help') }}}"></i>
										{{{ trans('sanatorium/stock::aliases/model.general.available') }}}
									</label>

									<input type="checkbox" name="available" id="available" placeholder="{{{ trans('sanatorium/stock::aliases/model.general.available') }}}" value="1" {{ $alias->available == 1 ? 'checked' : '' }}>

								</div>


							</div>

						</fieldset>

					</div>

					{{-- Tab: Attributes --}}
					<div role="tabpanel" class="tab-pane fade" id="attributes">
						@attributes($alias)
					</div>

				</div>

			</div>

		</div>

	</form>

</section>
@stop

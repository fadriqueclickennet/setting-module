@extends('layouts.master')

@section('content-header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ trans('setting::settings.title.module name settings', ['module' => ucfirst($currentModule)]) }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.setting.settings.index') }}"><i class="fa fa-cog"></i> {{ trans('setting::settings.breadcrumb.settings') }}</a></li>
                <li class="breadcrumb-item active"><i class="fa fa-cog"></i> {{ trans('setting::settings.breadcrumb.module settings', ['module' => ucfirst($currentModule)]) }}</li>
            </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>
@stop

@section('content')
{!! Form::open(['route' => ['admin.setting.settings.store'], 'method' => 'post']) !!}
<div class="container-fluid">
<div class="row">
    <div class="sidebar-nav col-2">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">{{ trans('setting::settings.title.module settings') }}</h3>
            </div>
            <style>
                a.active {
                    text-decoration: none;
                    background-color: #eee;
                }
            </style>
    		<ul class="card-body nav nav-pills">
    		  <?php foreach ($modulesWithSettings as $module => $settings): ?>
                  <li class="nav-item w-100">
                    <a href="{{ route('dashboard.module.settings', [$module]) }}"
                       class="nav-link {{ $module === $currentModule->getName() ? 'active' : '' }}">
                        {{ ucfirst($module) }}
                        <small class="badge float-right bg-blue">{{ count($settings) }}</small>
                    </a>
                    </li>
              <?php endforeach; ?>
    		</ul>
    	</div>
    </div>
    <div class="col-10">
        <?php if ($translatableSettings): ?>
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">{{ trans('core::core.title.translatable fields') }}</h3>
                </div>
                <div class="card-body">
                    <div class="nav-tabs-custom">
                        @include('partials.form-tab-headers')
                        <div class="tab-content">
                            <?php $i = 0; ?>
                            <?php foreach (LaravelLocalization::getSupportedLocales() as $locale => $language): ?>
                                <?php $i++; ?>
                                <div class="tab-pane {{ App::getLocale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                                    @include('setting::admin.partials.fields', ['settings' => $translatableSettings])
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($plainSettings): ?>
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">{{ trans('core::core.title.non translatable fields') }}</h3>
            </div>
            <div class="card-body">
                @include('setting::admin.partials.fields', ['settings' => $plainSettings])
            </div>
        </div>
        <?php endif; ?>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{ trans('core::core.button.update') }}</button>
            <a class="btn btn-danger float-right" href="{{ route('admin.setting.settings.index')}}"><i class="fas fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
        </div>
    </div>
</div>
</div>
{!! Form::close() !!}
@stop

@push('js-stack')
<script>
$( document ).ready(function() {
    $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });

    $('input[type="checkbox"]').on('ifChecked', function(){
      $(this).parent().find('input[type=hidden]').remove();
    });

    $('input[type="checkbox"]').on('ifUnchecked', function(){
      var name = $(this).attr('name'),
          input = '<input type="hidden" name="' + name + '" value="0" />';
      $(this).parent().append(input);
    });
});
</script>
@endpush

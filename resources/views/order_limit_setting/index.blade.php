
{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Datatables', true)

@section('content_header')
	<h1>{{__('data.min_order_lim')}}</h1>
@stop

@section('content')
<style>
    
    
</style>
@if(Session::has('message'))
    <p class="alert alert-success">{{ Session::get('message') }}</p>
@endif
<div class="card">
  <div class="card-body">
    <form method="post" action="order_limit_settings_update">
      <input type="hidden" name="_token" value="{{ csrf_token() }}" />
      <div class="form-group row">
        <label for="staticEmail" class=" col-md-3 col-sm-2 col-form-label">{{__('data.min_amount')}} ($):</label>
        <div class=" col-md-9 col-sm-10">
          <input type="number" name="order_limit" id="order_limit" class="form-control" placeholder="Enter minimum order amount" value="<?php echo $limit_settings->order_limit;?>" min="5">
        </div>
      </div>
      <button class="btn btn-success float-right">{{__('data.submit')}}</button>
    </form>
  </div>
</div>
@stop

@section('css')
@stop

@section('js')
@stop
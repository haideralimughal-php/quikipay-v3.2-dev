{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.bsCustomFileInput', true)

@section('content_header')
	<h1>{{__('data.changePassword')}}</h1>
@stop

@section('content')
	@include('errors')

	@if(session('error'))
		<div class="alert alert-danger" role="alert">
			{{ session('error') }}
		</div>
	@endif

	@if(session('success'))
		<div class="alert alert-success" role="alert">
			{{ session('success') }}
		</div>
	@endif

	<div id="settings">
		<form class="form-horizontal" action="/settings/security" method="POST">
			@csrf
			@method('PATCH')

			<div class="form-group row">
				<label for="currentPassword" class="col-sm-2 col-form-label">{{__('data.oldPassword')}}</label>
				<div class="col-sm-10">
					<input type="password" name="currentPassword" class="form-control" id="currentPassword" required>
				</div>
			</div>
			<div class="form-group row">
				<label for="newPassword" class="col-sm-2 col-form-label">{{__('data.newPassword')}}</label>
				<div class="col-sm-10">
					<input type="password" name="newPassword" class="form-control" id="newPassword" required>
				</div>
			</div>
			<div class="form-group row">
				<label for="confirmPassword" class="col-sm-2 col-form-label">{{__('data.confirmPassword')}}</label>
				<div class="col-sm-10">
					<input type="password" name="confirmPassword" class="form-control" id="confirmPassword" required>
				</div>
			</div>
			<div class="form-group row">
				<div class="offset-sm-2 col-sm-10">
					<button type="submit" class="btn btn-danger">{{__('data.submit')}}</button>
				</div>
			</div>
		</form>
	</div>
@stop

@section('css')
	<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
	<script> 
		console.log('Hi!'); 
		$(document).ready(function () {
			bsCustomFileInput.init()
		});
	</script>
@stop
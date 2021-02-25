{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.bsCustomFileInput', true)

@section('content_header')
	<h1>{{__('data.profile')}}</h1>
@stop

@section('content')
	@include('errors')
	<div id="settings">
		<form class="form-horizontal" action="/settings/profile" method="POST" enctype="multipart/form-data">
			@csrf
			@method('PATCH')

			<div class="form-group row">
				<label for="inputName" class="col-sm-2 col-form-label">{{__('data.name')}}</label>
				<div class="col-sm-10">
				<input type="text" name="name" class="form-control" id="inputName" placeholder="Name" value="{{ $user->name }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="inputName" class="col-sm-2 col-form-label">{{__('data.company_name')}}</label>
				<div class="col-sm-10">
				<input type="text" name="company_name" class="form-control" id="inputName" placeholder="Company Name" value="{{ $user->company_name }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="inputName" class="col-sm-2 col-form-label">{{__('data.contact')}}</label>
				<div class="col-sm-10">
				<input type="number" name="contact" class="form-control" id="inputName" placeholder="Contact" value="{{ $user->contact }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="inputEmail" class="col-sm-2 col-form-label">{{__('data.email')}}</label>
				<div class="col-sm-10">
				<input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email" value="{{ $user->email }}">
				</div>
			</div>
			<div class="form-group row">
				<label for="inputAddress" class="col-sm-2 col-form-label">{{__('data.adress')}}</label>
				<div class="col-sm-10">
				<textarea name="address" class="form-control" id="inputAddress" placeholder="Address">{{ $user->address }}</textarea>
				</div>
			</div>
			<div class="form-group row">
				<label for="exampleInputFile" class="col-sm-2 col-form-label">{{__('data.logo')}}</label>
				<div class="input-group col-sm-10">
					<div class="custom-file">
						<input type="file" name="logo" class="custom-file-input" id="exampleInputFile">
						<label class="custom-file-label" for="exampleInputFile">Choose file</label>
					</div>
					<div class="input-group-append">
						<span class="input-group-text" id="">{{__('data.upload')}}</span>
					</div>
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
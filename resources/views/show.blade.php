{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.bsCustomFileInput', true)

@section('content_header')
	<h1 class="text-capitalize">{{__('data.profile')}}</h1>
@stop

@section('content')
	@include('errors')
	<!-- Profile Image -->
	<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title"> {{__('data.companyProfile')}}</h3>
		</div>
		<div class="card-body box-profile">
			<div class="" style="text-align: right;">
				<img class="profile-user-img img-fluid "
				src="{{ asset('storage/' . $user->logo) }}"
				alt="User profile picture">
			</div>
			
			<br>
			
			
			<!-- /.card-header -->
			<div class="card-body">
				<div class="row">
					<div class="col-12 col-md-6">
						
						<strong><i class="fas fa-user mr-1"></i> {{__('data.name')}}</strong>
						
						<p class="text-muted">
							{{ $user->name }}
						</p>
						
						<hr>
						
						<strong><i class="fas fa-address-card mr-1"></i> {{__('data.adress')}}</strong>
						
						<p class="text-muted">{{ $user->address }}</p>
						
						<hr>
						
					</div>
					<div class="col-12 col-md-6">
						
						<strong><i class="fas fa-user mr-1"></i> {{__('data.company_name')}}</strong>
						
						<p class="text-muted">
							{{ $user->company_name }}
						</p>
						
						<hr>
						
						<strong><i class="fas fa-address-card mr-1"></i> {{__('data.contact')}}</strong>
						
						<p class="text-muted">{{ $user->contact }}</p>
						
						<hr>
						
					</div>
					<div class="col-12 col-md-6">
						
						<strong><i class="fas fa-envelope mr-1"></i> {{__('data.email')}}</strong>
						
						<p class="text-muted">
							{{ $user->email }}
						</p>
						<hr>
					</div>
				</div>
			</div>
			<!-- /.card-body -->
		</div>
		<!-- /.card -->
	</div>
	<!-- /Profile Image -->
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
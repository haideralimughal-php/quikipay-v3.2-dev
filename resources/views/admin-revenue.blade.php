{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{__('data.adminRevenue')}}</h1>
@stop

@section('content')
    <style>
        .bg-revenuecard{
            background-color: #343a40;
            background-image: linear-gradient(380deg, #343a40 40%, #fff 94%);
            color: #fff;
        }
    </style>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-6">
            <!-- small box -->
            <div class="small-box bg-revenuecard">
              <div class="inner">
                <p>{{__('data.adminRevenue')}}</p>
                <h3>$100</h3>
              </div>
            </div>
         </div>
         <div class="col-lg-4 col-md-4 col-6 d-none">
            <!-- small box -->
            <div class="small-box bg-revenuecard">
              <div class="inner">
                <p>{{__('data.merchantRevenue')}}</p>
                <h3>$100</h3>
              </div>
            </div>
         </div>
         <div class=" offset-lg-0 col-lg-4 offset-md-0 col-md-4 offset-3 col-6 d-none">
            <!-- small box -->
            <div class="small-box bg-revenuecard">
              <div class="inner">
                <p>{{__('data.userRevenue')}}</p>
                <h3>$100</h3>
              </div>
            </div>
         </div>
        
		<div class="col-12">
			<div class="card">
			    <form action="" method="post" class="form mx-3 pt-5">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                            <div class="input-group">
                                <label> <?php echo"By User type:";?></label>
                                <div class="input-group">
                                    <select name="status" class="form-control"> 
                                        <option selected disabled >Select User type</option>
                                        <option value="0" >All</option>
                                        <option value="1" >Merchant</option>
                                        <option value="2" >End User</option>
                                    </select>
                                </div>
                            </div>  
                        </div> 
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                            <div class="input-group">
                                <label> <?php echo"By Source:";?></label>
                                <div class="input-group">
                                    <select name="status" class="form-control"> 
                                        <option selected disabled >Select Source</option>
                                        <option value="0" >All</option>
                                        <option value="1" >Payment Gateway</option>
                                        <option value="2" >Currency Convertion</option>
                                    </select>
                                </div>
                            </div>  
                        </div>                     
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Date range:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" id="reservation">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <div class="input-group justify-content-end" style="margin-top:30px;">
                                <input type="submit" name="filter" class="btn btn-info btn-block" value="Filter" />
                            </div>
                        </div>
                    </div>
                </form>
				<div class="card-body">
				    <div class="table-responsive">
					    <table id="revenue" class="table  table-hover">
    						<thead>
    							<tr>
    								<th>{{__('data.sr')}}</th>
    								<th>{{__('data.revenueId')}}</th>
    								<th>{{__('data.userType')}}</th>
    								<th>{{__('data.amount')}}</th>
    								<th>{{__('data.sources')}}</th>
    								<th>{{__('data.date')}}</th>
    							</tr>
    						</thead>
    						<tbody>
    							<tr>
    								<td></td>
    								<td></td>
    								<td></td>
    								<td></td>
    								<td></td>
    								<td></td>
    							</tr>
    						</tbody>
					    </table>
				    </div>
				</div>
			</div>
		</div>
	</div>   
@stop

@section('css')
    <!--<link rel="stylesheet" href="/css/admin_custom.css">-->
    <!-- daterange picker -->
  <link rel="stylesheet" href="{{asset('vendor/adminlte/plugins/daterangepicker/daterangepicker.css')}}">
@stop

@section('js')
    <!-- date-range-picker -->
    <script src="{{asset('vendor/adminlte/plugins/daterangepicker/daterangepicker.js')}}"></script>
     <script> 
// 		console.log('Hi!'); 
// 		$("#revenue").DataTable({
// 			"responsive": true,
// 			"autoWidth": false,
// 		});
// 	</script>
@stop
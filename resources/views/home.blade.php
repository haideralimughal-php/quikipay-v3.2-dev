{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{__('data.dashboard')}}</h1>
@stop

@section('content')
    <!--<p>Welcome to this beautiful admin panel.</p>-->
    <style>
        .info-box{
            box-shadow:2px 2px 5px 3px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2);
        }
    </style>
    <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><b>USD</b></span>

              <div class="info-box-content">
                <span class="info-box-text"><h5 class="text-info text-wrap">{{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('usd'), 2) : number_format(auth()->user()->wallet->usd, 2) }}</h5>  </span>
                <!--<span class="info-box-number">-->
                <!--    {{ auth()->user()->wallet->usd }}-->
                <!--</span>-->
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><b>ARS</b></span>

              <div class="info-box-content">
                <span class="info-box-text"><h5 class="text-danger text-wrap">{{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('ars'), 2) : number_format(auth()->user()->wallet->ars, 2) }}</h5>  </span>
                <span class="text-danger" style="text-align:end"> = {{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('ars') / $ars, 2) : number_format(auth()->user()->wallet->ars / $ars, 2) }} USD</span>
                <!--<span class="info-box-number">{{ auth()->user()->wallet->ars }}</span>-->
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><b>CLP</b></span>

              <div class="info-box-content">
                <span class="info-box-text"><h5 class="text-success text-wrap">{{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('clp'), 2) : number_format(auth()->user()->wallet->clp, 2) }} </h5></span>
                <span class="text-success" style="text-align:end"> = {{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('clp') / $clp, 2) : number_format(auth()->user()->wallet->clp / $clp, 2) }} USD</span>
                <!--<span class="info-box-number">{{ auth()->user()->wallet->clp }}</span>-->
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><b>SOL</b></span>

              <div class="info-box-content">
                <span class="info-box-text"><h5 class="text-primary text-wrap">{{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('sol'), 2) : number_format(auth()->user()->wallet->sol, 2) }} </h5></span>
                <span class="text-primary" style="text-align:end"> = {{ auth()->user()->can('isAdmin') ? number_format(App\Wallet::sum('sol') / $pen, 2) : number_format(auth()->user()->wallet->sol / $pen, 2) }} USD</span>
                <!--<span class="info-box-number">{{ auth()->user()->wallet->sol }}</span>-->
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
    

        <div class="row">
            
          <div class="col-md-6">
              
            <!-- AREA CHART -->
            
            <div class="card card-primary" style= "<?php if(!auth()->user()->can('isAdmin')){ echo "display:none;" ;} ?>" >
              <div class="card-header">
                <h3 class="card-title">{{ __('data.numberOfMerchant') }}</h3>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            
            <!-- DONUT CHART -->
            <div class="card card-dark border border-dark">
              <div class="card-header">
                <h3 class="card-title text-white">{{ __('data.wallet') }}</h3>
              </div>
              <div class="card-body">
                <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            

          </div>
          <!-- /.col (LEFT) -->
            <div class="col-md-6">
            <!-- LINE CHART -->
            
            <div class="card card-info border border-info" style= "<?php if(!auth()->user()->can('isAdmin')){ echo "display:none;" ;} ?>">
              <div class="card-header">
                <h3 class="card-title">{{ __('data.numberOfOrders') }}</h3>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
           
            <!-- BAR CHART -->
            <div class="card card-dark border border-darky">
              <div class="card-header">
                <h3 class="card-title">{{ __('data.numberOfTransactions') }}</h3>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            

          </div>
          <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

@stop






@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="{{asset('vendor/adminlte/plugins/chart.js/Chart.min.js')}}"></script>
    <script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    
    
    
    // Area chart data print number of merchants
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
var data1  = [
        <?php
            foreach($areachart as $areachartarray){
        ?>
        '<?php echo $areachartarray->total; ?>',
            <?php    
            }
        ?>
        ];
    var areaChartData = {
        
        labels  : [
        <?php
            foreach($areachart as $areachartarray){
        ?>
        '<?php echo $areachartarray->month.' / '.$areachartarray->year ; ?>',
            <?php    
            }
        ?>
        ],
        
      datasets: [
       
        {
          label               : 'Merchents',
          backgroundColor     : '#007bff',
          borderColor         : '#007bff',
          pointRadius         : false,
          pointColor          : '#007bff',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : data1
        },
      ]
    }
    
    
    
    // line chart data print number of orders
    var lineData  = [
        <?php
            foreach($linechart as $linechartarray){
        ?>
        '<?php echo $linechartarray->total; ?>',
            <?php    
            }
        ?>
        ];
var lineChartData = {
    labels  : [
        <?php
            foreach($linechart as $linechartarray){
        ?>
        '<?php echo $linechartarray->day.' / '.$linechartarray->month ; ?>',
            <?php    
            }
        ?>
        ],
      datasets: [
       
        {
          label               : 'Electronics',
          backgroundColor     : '#17a2b8',
          borderColor         : '#17a2b8',
          pointRadius         : false,
          pointColor          : '#17a2b8',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : lineData
        },
      ]
    }
    
    
// Bar chart data print number of transactions
    var barData  = [
        <?php
            foreach($barchart as $barchartarray){
        ?>
        '<?php echo $barchartarray->total; ?>',
            <?php    
            }
        ?>
        ];
    var barChartData = {
      labels  : [
        <?php
            foreach($barchart as $barchartarray){
        ?>
        '<?php echo $barchartarray->day.' / '.$barchartarray->month ; ?>',
            <?php    
            }
        ?>
        ],
      datasets: [
       
        {
          label               : 'Transactions',
          backgroundColor     : '#28a745',
          borderColor         : '#28a745',
          pointRadius         : false,
          pointColor          : '#28a745',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : barData
        },
      ]
    }
    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    } 
    var lineChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }
    var barChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas, { 
      type: 'line',
      data: areaChartData, 
      options: areaChartOptions
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    var lineChartOptions = jQuery.extend(true, {}, areaChartOptions)
    var lineChartData = jQuery.extend(true, {}, lineChartData)
    lineChartData.datasets[0].fill = false;
    
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, { 
      type: 'line',
      data: lineChartData, 
      options: lineChartOptions
    })

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          'USD', 
          'ARS',
          'CLP', 
          'SOL' 
      ],
      datasets: [
        {
          data: [
              {{ auth()->user()->can('isAdmin') ? round(App\Wallet::sum('usd')) : round(auth()->user()->wallet->usd) }},
              {{ auth()->user()->can('isAdmin') ? round(App\Wallet::sum('ars')) : round(auth()->user()->wallet->ars) }},
              {{ auth()->user()->can('isAdmin') ? round(App\Wallet::sum('clp')) : round(auth()->user()->wallet->clp) }},
              {{ auth()->user()->can('isAdmin') ? round(App\Wallet::sum('sol')) : round(auth()->user()->wallet->sol) }}],
          backgroundColor : ['#00c0ef','#f56954', '#00a65a', '#007bff ', ],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var donutChart = new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions      
    })

    
    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = jQuery.extend(true, {}, barChartData)
    var temp0 = barChartData.datasets[0]
    
    barChartData.datasets[0] = temp0
   

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    var barChart = new Chart(barChartCanvas, {
      type: 'bar', 
      data: barChartData,
      options: barChartOptions
    })

 
  })
</script>
@stop
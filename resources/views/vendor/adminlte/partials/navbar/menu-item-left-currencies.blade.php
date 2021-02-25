<style>
.info-box1{
    border-radius:0;
    height:auto;
    min-height:35px;
    min-width:100px;
    padding:0;
    padding:right:5px;
}
    .info-box1 .info-box-icon1{
        font-size:12px;
        width:35px;
        border-radius:0;
    }
</style>

<div class="container-fluid">


<div class="row w-100">
          <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
            <div class="info-box info-box1">
              <span class="info-box-icon info-box-icon1 bg-info elevation-1">USD</span>

              <div class="info-box-content" >
                <!--<span class="info-box-text">CPU Traffic</span>-->
                <span class="info-box-number text-info" style="height:38px">
                  {{ auth()->user()->can('isAdmin') ? number_format(round(App\Wallet::sum('usd'), 3), 2) : number_format(round(auth()->user()->wallet->usd, 3), 2) }}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
            <div class="info-box info-box1 mb-3">
              <span class="info-box-icon info-box-icon1 bg-danger elevation-1">ARS</span>

              <div class="info-box-content">
                <!--<span class="info-box-text">Likes</span>-->
                <span class="info-box-number text-danger">
                    {{ auth()->user()->can('isAdmin') ? number_format(round(App\Wallet::sum('ars'), 3), 2) : number_format(round(auth()->user()->wallet->ars, 3), 2) }}</span>
                <span class="text-danger" style="text-align:end">1 USD={{ round($ars, 3) }} ARS</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
            <div class="info-box info-box1 mb-3">
              <span class="info-box-icon info-box-icon1 bg-success elevation-1">CLP</span>

              <div class="info-box-content">
                <!--<span class="info-box-text">Sales</span>-->
                <span class="info-box-number text-success">
                    {{ auth()->user()->can('isAdmin') ? number_format(round(App\Wallet::sum('clp'), 3), 2) : number_format(round(auth()->user()->wallet->clp, 3), 2) }} 
                    </span>
                    <span class="text-success" style="text-align:end">1 USD={{ round($clp, 3) }} CLP</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
            <div class="info-box info-box1 mb-3">
              <span class="info-box-icon info-box-icon1 bg-primary elevation-1">SOL</span>

              <div class="info-box-content">
                <!--<span class="info-box-text">New Members</span>-->
                <span class="info-box-number text-primary">
                    {{ auth()->user()->can('isAdmin') ? number_format(round(App\Wallet::sum('sol'), 3), 2) : number_format(round(auth()->user()->wallet->sol, 3), 2) }} 
                </span>
                <span class="text-primary" style="text-align:end">1 USD={{ round($pen, 3) }} SOL</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          
          
          <!-- /.col -->
          <!--<div class="col-12 col-sm-6 col-md-3">-->
          <!--    <button class="btn btn-primary" style="border-radius:50%"><i class="fas fa-fw fa-recycle"></i></button>-->
          <!--</div>-->
          <!-- /.col -->
          
        </div>
</div>

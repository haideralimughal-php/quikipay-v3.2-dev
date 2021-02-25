<?php
// print_r($data);
// print_r($data["chile"][0]->bacs);
// echo $data["chile"][0]->bacs;
?>
{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Datatables', true)

@section('content_header')
	<h1>Service Fees</h1>
@stop

@section('content')
<style>
    
    
</style>
<div class="table-responsive">
    <table class="table table-bordered">
      <thead class="bg-light">
          
        <tr>
          <th scope="col">RATES FOR PAYMENT METHODS <br>PROCESSING </th>
          <th scope="col" class="text-center"><img src="{{ asset('payImages/chilean-flag-small.png') }}" height="30px" width="45px"><br>Chile </th>
          <th scope="col" class="text-center"><img src="{{ asset('payImages/argentinian-flag-small.png') }}" height="30px" width="45px"><br>Argentina </th>
          <th scope="col" class="text-center"><img src="{{ asset('payImages/NicePng_peru-flag-png.png') }}" height="30px" width="45px"><br>Peru</th>
          <th scope="col" class="text-center"><img src="{{ asset('payImages/panamanian-flag-small.png') }}" height="30px" width="45px"><br>Panama</th>
          <th scope="col" class="text-center"><img src="{{ asset('payImages/venezuelan-flag-small.png') }}" height="30px" width="45px"><br>Venezuela</th>
          <th scope="col" class="text-center"><img src="{{ asset('payImages/others-flags.png') }}" height="35px" width="35px"><br>Others</th>
        </tr>
      </thead>
      <tbody>
        
            <tr>
                <td><b>ELECTRONIC TRANSFER / DEPOSIT</b> <br>(MANUAL CONFIRMATION)</td>
                <td class="text-center"><?php echo $data["chile"][0]->bacs; ?>%</td>
                <td class="text-center"><?php echo $data["ars"][0]->bacs; ?>%</td>
                <td class="text-center"><?php echo $data["peru"][0]->bacs; ?>%</td>
                <td class="text-center"><?php echo $data["panama"][0]->bacs; ?></td>
                <td class="text-center"><?php echo $data["venz"][0]->bacs; ?>%</td>
                <td class="text-center"><?php echo $data["other"][0]->bacs; ?></td> 
            </tr>
            <tr>
                <td>ONLINE CASH PAYMENT PAGO 46</td>
                <td class="text-center"><?php echo $data["chile"][0]->pago; ?>%</td>
                <td class="text-center"><?php echo $data["ars"][0]->pago; ?>%</td>
                <td class="text-center"><?php echo $data["peru"][0]->pago; ?></td>
                <td class="text-center"><?php echo $data["panama"][0]->pago; ?></td>
                <td class="text-center"><?php echo $data["venz"][0]->pago; ?></td>
                <td class="text-center"><?php echo $data["other"][0]->pago; ?></td> 
            </tr>
            <tr>
                <td>DEBIT CARD AND CREDIT CARD</td>
                <td class="text-center"><?php echo $data["chile"][0]->debit_credit; ?>%</td>
                <td class="text-center"><?php echo $data["ars"][0]->debit_credit; ?>%</td>
                <td class="text-center"><?php echo $data["peru"][0]->debit_credit; ?>%</td>
                <td class="text-center"><?php echo $data["panama"][0]->debit_credit; ?>%</td>
                <td class="text-center"><?php echo $data["venz"][0]->debit_credit; ?>%</td>
                <td class="text-center"><?php echo $data["other"][0]->debit_credit; ?>%</td> 
            </tr>
            <tr>
                <td>CRYPTO PAYMENT (*)</td>
                <td class="text-center"><?php echo $data["chile"][0]->crypto; ?>%</td>
                <td class="text-center"><?php echo $data["ars"][0]->crypto; ?>%</td>
                <td class="text-center"><?php echo $data["peru"][0]->crypto; ?>%</td>
                <td class="text-center"><?php echo $data["panama"][0]->crypto; ?>%</td>
                <td class="text-center"><?php echo $data["venz"][0]->crypto; ?>%</td>
                <td class="text-center"><?php echo $data["other"][0]->crypto; ?>%</td> 
            </tr>
            <tr>
                <td>HITES</td>
                <td class="text-center"><?php echo $data["chile"][0]->hites; ?>%</td>
                <td class="text-center"><?php echo $data["ars"][0]->hites; ?></td>
                <td class="text-center"><?php echo $data["peru"][0]->hites; ?></td>
                <td class="text-center"><?php echo $data["panama"][0]->hites; ?></td>
                <td class="text-center"><?php echo $data["venz"][0]->hites; ?></td>
                <td class="text-center"><?php echo $data["other"][0]->hites; ?></td> 
            </tr>
            <tr>
                <td>FEE FOR CONVERSION LOCAL CURRENCY TO USD</td>
                <td class="text-center"><?php echo $data["chile"][0]->conversion; ?>%</td>
                <td class="text-center"><?php echo $data["ars"][0]->conversion; ?>%</td>
                <td class="text-center"><?php echo $data["peru"][0]->conversion; ?>%</td>
                <td class="text-center"><?php echo $data["panama"][0]->conversion; ?>%</td>
                <td class="text-center"><?php echo $data["venz"][0]->conversion; ?>%</td>
                <td class="text-center"><?php echo $data["other"][0]->conversion; ?>%</td> 
            </tr>
            <tr>
                <td colspan="7" class="">RATES INCLUDE VAT</td>
            </tr>
      </tbody>
    </table>
</div>
@stop

@section('css')
@stop

@section('js')
@stop
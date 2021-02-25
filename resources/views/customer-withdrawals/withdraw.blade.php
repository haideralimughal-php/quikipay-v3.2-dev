{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')


@section('title', 'Dashboard')

@section('content_header')
      @if($param =='w')         
    	<h1>{{__('data.withdraw')}}</h1>
    @else
    	<h1>{{__('data.payout')}}</h1>
    @endif
@stop

@section('content')
    <!--<p>Welcome to this beautiful admin panel.</p>-->
    
    <style>
        .info-box{
            box-shadow:2px 2px 5px 3px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2);
        }
        .option-custom-style option{
            background-color:#fff; 
            color:black; 
            font-size:15px;  
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
    
    <div class="accordion" id="accordionExample">
      <div class="card">
        <div class="card-header" id="headingOne">
          <h2 class="mb-0">
            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              {{__('data.lBank')}}
            </button>
          </h2>
        </div>
        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card-body">
            <form class="row" action="/withdraw" method="post" id="with-form">
                @csrf
                <input type="hidden" name="bank" value="local_bank" />
                <input type="hidden" name="type" value="{{ $param }}" />
                <div class="form-group col-md-6">
                    <label>{{__('data.name')}}</label>
                    <input type="text" value="{{ auth()->user()->name }}" class="form-control" required="" name="Name" disabled="disabled">
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('data.countryName')}}</label>
                    <select name="country" required="" class="form-control option-custom-style" onchange="getcountry()" id="getCountry">
                        <option disable selected>Choose Country</option>
                        <option value="Chile">Chile</option>
                        <!--<option value="Panama&#769;">Panama&#769;</option>-->
                        <option value="Argentina">Argentina</option>
                        <option value="PERU">PERU</option>
                        <option value="Venezuela">Venezuela</option>
                    </select>
                </div>
                <div class="form-group col-md-6 d-none" id="bankSelect">
                    <label>{{__('data.bankName')}}</label>
                    <select name="bank_name" required="" class="form-control option-custom-style">
                        @if(!is_null($local_bank))
                            <option value="{{ $local_bank->getBank->bank_name }}" selected>{{ $local_bank->getBank->bank_name }}</option>
                        @endif
                        <optgroup label="Chile" style="background-color:#343a40; color:white; font-size:18px; padding-top:10px; padding-bottom:10px;">
                            <option value="Banco BBVA">Banco BBVA</option>
                            <option value="Banco BCI">Banco BCI</option>
                            <option value="Banco BICE">Banco BICE</option>
                            <option value="Banco Consorcio">Banco Consorcio</option>
                            <option value="Banco Corpbanca">Banco Corpbanca</option>
                            <option value="Banco de Chile (Edwards, Citi)">Banco de Chile (Edwards, Citi)</option>
                            <option value="Banco Estado">Banco Estado</option>
                            <option value="Banco Falabella">Banco Falabella</option>
                            <option value="Banco ITAU">Banco ITAU</option>
                            <option value="Banco Santander">Banco Santander</option>
                            <option value="Banco Security">Banco Security</option>
                            <option value="Banco Ripley">Banco Ripley</option>
                            <option value="Banco Santander BANEFE">Banco Santander BANEFE</option>
                            <option value="Banco Internacional">Banco Internacional</option>
                            <option value="Scotiabank">Scotiabank</option>
                        </optgroup>
                        <optgroup label="Panama&#769;" style="background-color:#343a40; color:white; font-size:18px; padding-top:10px; padding-bottom:10px;">
                            <option value="Banco General">Banco General</option>
                            <option value="Banistmo">Banistmo</option>
                            <option value="Banco Nacional de Panama&#769;">Banco Nacional de Panama&#769;</option>
                            <option value="Multibank">Multibank</option>
                            <option value="BNP Paribas (Panama&#769;)">BNP Paribas (Panama&#769;)</option>
                            <option value="BAC INTERNATIONAL BANK INC.">BAC INTERNATIONAL BANK INC.</option>
                            <option value="Global Bank (Panama&#769;)">Global Bank (Panama&#769;)</option>
                            <option value="Inteligo Bank, Ltd.">Inteligo Bank, Ltd.</option>
                            <option value="Caja de Ahorros">Caja de Ahorros</option>
                            <option value="Banesco Panama&#769; (Panama&#769;)">Banesco Panama&#769; (Panama&#769;)</option>
                            <option value="Scotiabank Transforma&#769;ndose">Scotiabank Transforma&#769;ndose</option>
                            <option value="The Bank of Nova Scotia (Panama&#769;)">The Bank of Nova Scotia (Panama&#769;)</option>
                            <option value="Banco Aliado">Banco Aliado</option>
                            <option value="Banco Latinoamericano de Exportaciones (BLADEX)">Banco Latinoamericano de Exportaciones (BLADEX)</option>
                            <option value="Banvivienda">Banvivienda</option>
                            <option value="Credicorp Bank">Credicorp Bank</option>
                            <option value="Banco Azteca (Panama&#769;)">Banco Azteca (Panama&#769;)</option>
                            <option value="Canal Bank">Canal Bank</option>
                            <option value="St. Georges Bank & Co.">St. Georges Bank & Co.</option>
                            <option value="Bancolombia (Panama&#769;)">Bancolombia (Panama&#769;)</option>
                            <option value="Banco de Cre&#769;dito del Peru&#769; (Panama&#769;)">Banco de Cre&#769;dito del Peru&#769; (Panama&#769;)</option>
                            <option value="Primer Banco del Istmo">Primer Banco del Istmo</option>
                            <option value="GTC Bank Inc.">GTC Bank Inc.</option>
                            <option value="GNB Sudameris Bank">GNB Sudameris Bank</option>
                            <option value="ES Bank (Panama&#769;)">ES Bank (Panama&#769;)</option>
                            <option value="Unibank">Unibank</option>
                            <option value="Banco Internacional de Costa Rica">Banco Internacional de Costa Rica</option>
                            <option value="Banco de Bogota&#769; (Panama&#769;)">Banco de Bogota&#769; (Panama&#769;)</option>
                            <option value="Popular Bank">Popular Bank</option>
                            <option value="BCT Bank International">BCT Bank International</option>
                            <option value="Towerbank International">Towerbank International</option>
                            <option value="Produbank (Panama&#769;)">Produbank (Panama&#769;)</option>
                            <option value="Banco de Occidente(Panama&#769;)">Banco de Occidente(Panama&#769;)</option>
                            <option value="Banco Pichincha Panama&#769;">Banco Pichincha Panama&#769;</option>
                            <option value="Banco de Cre&#769;dito Helm Financial Services (Panama&#769;)">Banco de Cre&#769;dito Helm Financial Services (Panama&#769;)</option>
                            <option value="Banco Davivienda (Panama&#769;)">Banco Davivienda (Panama&#769;)</option>
                            <option value="Mega International Commercial Bank (Panama&#769;)">Mega International Commercial Bank (Panama&#769;)</option>
                            <option value="MMG Bank (Panama&#769;)">MMG Bank (Panama&#769;)</option>
                            <option value="FPB International Bank">FPB International Bank</option>
                            <option value="Banco Transatla&#769;ntico">Banco Transatla&#769;ntico</option>
                            <option value="Banco del Paci&#769;fico (Panama&#769;)">Banco del Paci&#769;fico (Panama&#769;)</option>
                            <option value="Korea Exchange Bank (Panama&#769;)">Korea Exchange Bank (Panama&#769;)</option>
                            <option value="Bank Leumi Le-Israel (Panama&#769;)">Bank Leumi Le-Israel (Panama&#769;)</option>
                            <option value="Austrobank Overseas (Panama&#769;)">Austrobank Overseas (Panama&#769;)</option>
                            <option value="Metrobank">Metrobank</option>
                            <option value="Banco Santander (Panama&#769;)">Banco Santander (Panama&#769;)</option>
                            <option value="BHD International Bank (Panama&#769;)">BHD International Bank (Panama&#769;)</option>
                            <option value="Mercantil Bank">Mercantil Bank</option>
                            <option value="Banco Lafise Panama&#769;">Banco Lafise Panama&#769;</option>
                            <option value="Banco Delta">Banco Delta</option>
                            <option value="Banco Corficolombiana">Banco Corficolombiana</option>
                            <option value="Bank of China (Panama&#769;)">Bank of China (Panama&#769;)</option>
                            <option value="International Union Bank">International Union Bank</option>
                            <option value="Stanford Bank (Panama&#769;)">Stanford Bank (Panama&#769;)</option>
                            <option value="Blubank">Blubank</option>
                            <option value="Banco do Brasil (Panama&#769;)">Banco do Brasil (Panama&#769;)</option>
                            <option value="Atlantic Security Bank">Atlantic Security Bank</option>
                            <option value="Banco de la Provincia de Buenos Aires (Panama&#769;)">Banco de la Provincia de Buenos Aires (Panama&#769;)</option>
                            <option value="Banco Hipotecario Nacional">Banco Hipotecario Nacional</option>
                            <option value="Banco de Guayaquil (Panama&#769;)">Banco de Guayaquil (Panama&#769;)</option>
                            <option value="Banco Panama&#769;">Banco Panama&#769;</option>
                            <option value="Capital Bank">Capital Bank</option>
                            <option value="Banco de la Nacio&#769;n Argentina (Panama&#769;)">Banco de la Nacio&#769;n Argentina (Panama&#769;)</option>
                            <option value="Banco Credit Andorra (Panama&#769;)">Banco Credit Andorra (Panama&#769;)</option>
                            <option value="Andorra Banc Agri&#769;col Reig (Panama&#769;)">Andorra Banc Agri&#769;col Reig (Panama&#769;)</option>
                            <option value="Cayman National Bank (Panama&#769;)">Cayman National Bank (Panama&#769;)</option>
                            <option value="Socie&#769;te&#769; Ge&#769;ne&#769;rale (Panama&#769;)">Socie&#769;te&#769; Ge&#769;ne&#769;rale (Panama&#769;)</option>
                            <option value="Capital Bank (Panama&#769;)">Capital Bank (Panama&#769;)</option>
                            <option value="Banco FICOHSA (Panama&#769;)">Banco FICOHSA (Panama&#769;)</option>
                        </optgroup>
                        <optgroup label="PERU" style="background-color:#343a40; color:white; font-size:18px; padding-top:10px; padding-bottom:10px;">
                            <option value="Banco de Comercio">Banco de Comercio</option>
                            <option value="Banco de Crédito del Peru&#769;">Banco de Crédito del Peru&#769;</option>
                            <option value="Banco Interamericano de Finanzas (BanBif)">Banco Interamericano de Finanzas (BanBif)</option>
                            <option value="Banco Pichincha">Banco Pichincha</option>
                            <option value="BBVA">BBVA</option>
                            <option value="Citibank Peru&#769;">Citibank Peru&#769;</option>
                            <option value="Interbank">Interbank</option>
                            <option value="MiBanco">MiBanco</option>
                            <option value="Scotiabank Peru&#769;">Scotiabank Peru&#769;</option>
                            <option value="Banco GNB Peru&#769;">Banco GNB Peru&#769;</option>
                            <option value="Banco Falabella">Banco Falabella</option>
                            <option value="Banco Ripley">Banco Ripley</option>
                            <option value="Banco Santander Peru&#769;">Banco Santander Peru&#769;</option>
                            <option value="Banco Azteca">Banco Azteca</option>
                            <option value="CRAC CAT Peru&#769;">CRAC CAT Peru&#769;</option>
                            <option value="ICBC PERU BANK">ICBC PERU BANK</option>
                        </optgroup>
                        <optgroup label="Venezuela" style="background-color:#343a40; color:white; font-size:18px; padding-top:10px; padding-bottom:10px;">
                            <option value="Banco de Venezuela">Banco de Venezuela</option>
                            <option value="Banesco">Banesco</option>
                            <option value="BBVA Banco Provincial">BBVA Banco Provincial</option>
                            <option value="Banco Mercantil">Banco Mercantil</option>
                            <option value="Bicentenario Banco Universal">Bicentenario Banco Universal</option>
                            <option value="Banco Occidental de Descuento BOD">Banco Occidental de Descuento BOD</option>
                            <option value="Bancaribe">Bancaribe</option>
                            <option value="Banco Exterior">Banco Exterior</option>
                            <option value="Banco del Tesoro">Banco del Tesoro</option>
                            <option value="Banco Industrial de Venezuela (se rige por medio de una Ley Especial)">Banco Industrial de Venezuela (se rige por medio de una Ley Especial)</option>
                            <option value="Banco Nacional de Crédito BNC">Banco Nacional de Crédito BNC</option>
                            <option value="BFC">BFC</option>
                            <option value="Venezolano de Crédito">Venezolano de Crédito</option>
                            <option value="Banco Caroni&#769;">Banco Caroni&#769;</option>
                            <option value="Banco Agri&#769;cola de Venezuela">Banco Agri&#769;cola de Venezuela</option>
                            <option value="Banco Sofitasa">Banco Sofitasa</option>
                            <option value="Banco Plaza">Banco Plaza</option>
                            <option value="Del Sur">Del Sur</option>
                            <option value="Citibank">Citibank</option>
                            <option value="Banco Activo">Banco Activo</option>
                            <option value="Banplus">Banplus</option>
                            <option value="100% Banco">100% Banco</option>
                        </optgroup>
                        <optgroup label="Argentina" style="background-color:#343a40; color:white; font-size:18px; padding-top:10px; padding-bottom:10px;">
                            <option value="BANCO DE GALICIA Y BUENOS AIRES S.A.U.">BANCO DE GALICIA Y BUENOS AIRES S.A.U.</option>
                            <option value="BANCO DE LA NACION ARGENTINA">BANCO DE LA NACION ARGENTINA</option>
                            <option value="BANCO DE LA PROVINCIA DE BUENOS AIRES">BANCO DE LA PROVINCIA DE BUENOS AIRES</option>
                            <option value="INDUSTRIAL AND COMMERCIAL BANK OF CHINA">INDUSTRIAL AND COMMERCIAL BANK OF CHINA</option>
                            <option value="BCITIBANK N.A.">CITIBANK N.A.</option>
                            <option value="BANCO BBVA ARGENTINA S.A.">BANCO BBVA ARGENTINA S.A.</option>
                            <option value="BANCO DE LA PROVINCIA DE CORDOBA S.A.">BANCO DE LA PROVINCIA DE CORDOBA S.A.</option>
                            <option value="BANCO SUPERVIELLE S.A.">BANCO SUPERVIELLE S.A.</option>
                            <option value="BANCO DE LA CIUDAD DE BUENOS AIRES">BANCO DE LA CIUDAD DE BUENOS AIRES</option>
                            <option value="BANCO PATAGONIA S.A.">BBANCO PATAGONIA S.A.</option>
                            <option value="BANCO HIPOTECARIO S.A.">BANCO HIPOTECARIO S.A.</option>
                            <option value="BANCO DE SAN JUAN S.A.">BANCO DE SAN JUAN S.A.</option>
                            <option value="BANCO MUNICIPAL DE ROSARIO">BANCO MUNICIPAL DE ROSARIO</option>
                            <option value="BANCO SANTANDER RIO S.A.">BANCO SANTANDER RIO S.A.</option>
                            <option value="BANCO DEL CHUBUT S.A.">BANCO DEL CHUBUT S.A.</option>
                            <option value="BANCO DE SANTA CRUZ S.A.">BANCO DE SANTA CRUZ S.A.</option>
                            <option value="BANCO DE LA PAMPA SOCIEDAD DE ECONOMI&#769;A M">BANCO DE LA PAMPA SOCIEDAD DE ECONOMI&#769;A M</option>
                            <option value="BANCO DE CORRIENTES S.A.">BANCO DE CORRIENTES S.A.</option>
                            <option value="BANCO PROVINCIA DEL NEUQUÉN SOCIEDAD ANÓ">BANCO PROVINCIA DEL NEUQUÉN SOCIEDAD ANÓ</option>
                            <option value="BRUBANK S.A.U.">BRUBANK S.A.U.</option>
                            <option value="BANCO INTERFINANZAS S.A.">BANCO INTERFINANZAS S.A.</option>
                            <option value="HSBC BANK ARGENTINA S.A.">HSBC BANK ARGENTINA S.A.</option>
                            <option value="JPMORGAN CHASE BANK, NATIONAL ASSOCIATIO">JPMORGAN CHASE BANK, NATIONAL ASSOCIATIO</option>
                            <option value="BANCO CREDICOOP COOPERATIVO LIMITADO">BANCO CREDICOOP COOPERATIVO LIMITADO</option>
                            <option value="BANCO DE VALORES S.A.">BANCO DE VALORES S.A.</option>
                            <option value="BANCO ROELA S.A.">BANCO ROELA S.A.</option>
                            <option value="BANCO MARIVA S.A.">BANCO MARIVA S.A.</option>
                            <option value="BANCO ITAU ARGENTINA S.A.">BANCO ITAU ARGENTINA S.A.</option>
                            <option value="BANK OF AMERICA, NATIONAL ASSOCIATION">BANK OF AMERICA, NATIONAL ASSOCIATION</option>
                            <option value="BNP PARIBAS">BNP PARIBAS</option>
                            <option value="BANCO PROVINCIA DE TIERRA DEL FUEGO">BANCO PROVINCIA DE TIERRA DEL FUEGO</option>
                            <option value="BANCO DE LA REPUBLICA ORIENTAL DEL URUGU">BANCO DE LA REPUBLICA ORIENTAL DEL URUGU</option>
                            <option value="BANCO SAENZ S.A.">BANCO SAENZ S.A.</option>
                            <option value="BANCO MERIDIAN S.A.">BANCO MERIDIAN S.A.</option>
                            <option value="BANCO MACRO S.A.">BANCO MACRO S.A.</option>
                            <option value="BANCO COMAFI SOCIEDAD ANONIMA">BANCO COMAFI SOCIEDAD ANONIMA</option>
                            <option value="BANCO DE INVERSION Y COMERCIO EXTERIOR S">BANCO DE INVERSION Y COMERCIO EXTERIOR S</option>
                            <option value="BANCO PIANO S.A.">BANCO PIANO S.A.</option>
                            <option value="BANCO JULIO SOCIEDAD ANONIMA">BANCO JULIO SOCIEDAD ANONIMA</option>
                            <option value="BANCO RIOJA SOCIEDAD ANONIMA UNIPERSONAL">BANCO RIOJA SOCIEDAD ANONIMA UNIPERSONAL</option>
                            <option value="BANCO DEL SOL S.A.">BANCO DEL SOL S.A.</option>
                            <option value="NUEVO BANCO DEL CHACO S. A.">NUEVO BANCO DEL CHACO S.A.</option>
                            <option value="BANCO VOII S.A.">BANCO VOII S.A.</option>
                            <option value="BANCO DE FORMOSA S.A.">BANCO DE FORMOSA S.A.</option>
                            <option value="BANCO CMF S.A.">BANCO CMF S.A.</option>
                            <option value="BANCO DE SANTIAGO DEL ESTERO S.A.">BANCO DE SANTIAGO DEL ESTERO S.A.</option>
                            <option value="BANCO INDUSTRIAL S.A.">BANCO INDUSTRIAL S.A.</option>
                            <option value="NUEVO BANCO DE SANTA FE SOCIEDAD ANONIMA">NUEVO BANCO DE SANTA FE SOCIEDAD ANONIMA</option>
                            <option value="BANCO CETELEM ARGENTINA S.A.">BANCO CETELEM ARGENTINA S.A.</option>
                            <option value="BANCO DE SERVICIOS FINANCIEROS S.A.">BANCO DE SERVICIOS FINANCIEROS S.A.</option>
                            <option value="BANCO BRADESCO ARGENTINA S.A.U.">BANCO BRADESCO ARGENTINA S.A.U.</option>
                            <option value="BANCO DE SERVICIOS Y TRANSACCIONES S.A.">BANCO DE SERVICIOS Y TRANSACCIONES S.A.</option>
                            <option value="RCI BANQUE S.A.">RCI BANQUE S.A.</option>
                            <option value="BACS BANCO DE CREDITO Y SECURITIZACION S">BACS BANCO DE CREDITO Y SECURITIZACION S</option>
                            <option value="BANCO MASVENTAS S.A.">BANCO MASVENTAS S.A.</option>
                            <option value="WILOBANK S.A.">WILOBANK S.A.</option>
                            <option value="NUEVO BANCO DE ENTRE RI&#769;OS S.A.">NUEVO BANCO DE ENTRE RI&#769;OS S.A.</option>
                            <option value="BANCO COLUMBIA S.A.">BANCO COLUMBIA S.A.</option>
                            <option value="BANCO BICA S.A.">BANCO BICA S.A.</option>
                            <option value="BANCO COINAG S.A.">BANCO COINAG S.A.</option>
                            <option value="BANCO DE COMERCIO S.A.">BANCO DE COMERCIO S.A.</option>
                            <option value="BANCO SUCREDITO REGIONAL S.A.U.">BANCO SUCREDITO REGIONAL S.A.U.</option>
                            <option value="BANCO DINO S.A.">BANCO DINO S.A.</option>
                            <option value="BANK OF CHINA LIMITED SUCURSAL BUENOS AI">BANK OF CHINA LIMITED SUCURSAL BUENOS AI</option>
                            <option value="FORD CREDIT COMPAÑIA FINANCIERA S.A.">FORD CREDIT COMPAÑIA FINANCIERA S.A.</option>
                            <option value="COMPAÑIA FINANCIERA ARGENTINA S.A.">CCOMPAÑIA FINANCIERA ARGENTINA S.A.</option>
                            <option value="VOLKSWAGEN FINANCIAL SERVICES COMPAÑIA F">VOLKSWAGEN FINANCIAL SERVICES COMPAÑIA F</option>
                            <option value="CORDIAL COMPAÑI&#769;A FINANCIERA S.A.">CORDIAL COMPAÑI&#769;A FINANCIERA S.A.</option>
                            <option value="FCA COMPAÑIA FINANCIERA S.A.">FCA COMPAÑIA FINANCIERA S.A.</option>
                            <option value="GPAT COMPAÑIA FINANCIERA S.A.U.">GPAT COMPAÑIA FINANCIERA S.A.U.</option>
                            <option value="MERCEDES-BENZ COMPAÑI&#769;A FINANCIERA ARGENT">MERCEDES-BENZ COMPAÑI&#769;A FINANCIERA ARGENT</option>
                            <option value="ROMBO COMPAÑI&#769;A FINANCIERA S.A.">ROMBO COMPAÑI&#769;A FINANCIERA S.A.</option>
                            <option value="JOHN DEERE CREDIT COMPAÑI&#769;A FINANCIERA S.">JOHN DEERE CREDIT COMPAÑI&#769;A FINANCIERA S.</option>
                            <option value="PSA FINANCE ARGENTINA COMPAÑI&#769;A FINANCIER">PSA FINANCE ARGENTINA COMPAÑI&#769;A FINANCIER</option>
                            <option value="TOYOTA COMPAÑI&#769;A FINANCIERA DE ARGENTINA">TOYOTA COMPAÑI&#769;A FINANCIERA DE ARGENTINA</option>
                            <option value="MONTEMAR COMPAÑIA FINANCIERA S.A.">MONTEMAR COMPAÑIA FINANCIERA S.A.</option>
                            <option value="TRANSATLANTICA COMPAÑIA FINANCIERA S.A.">TRANSATLANTICA COMPAÑIA FINANCIERA S.A.</option>
                            <option value="CREDITO REGIONAL COMPAÑIA FINANCIERA S.A">CREDITO REGIONAL COMPAÑIA FINANCIERA S.A</option>
                        </optgroup>
                    </select>
                </div>
             
                <div class="form-group col-md-6">
                    <label>{{__('data.accoType')}}</label>
                    <select name="account_type" required="" class="form-control">
                        @if(!is_null($local_bank))
                            <option value="{{ $local_bank->getBank->account_type }}" selected>{{ $local_bank->getBank->account_type }}</option>
                        @endif
                        <option value="Cuenta CORRIENTE">Cuenta CORRIENTE</option>
                        <option value="Cuenta AHORROS">Cuenta AHORROS</option>
                        <option value="Cuenta VISTA">Cuenta VISTA</option>
                        <option value="Cuenta Chequera Electr贸nica">Cuenta Chequera Electr贸nica</option>
                        <option value="Cuenta RUT">Cuenta RUT</option>
                    </select>
                </div>
            
                
                <div class="form-group col-md-6">
                    <label>{{__('data.bankAccountNumber')}}</label>
                    <input type="text" class="form-control" required="" name="bank_account_number" value="{{ !is_null($local_bank) ? $local_bank->getBank->bank_account_number : '' }}">
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('data.currency')}}</label>
                    <select class="form-control" name="currency" required="" id="local-currency">
                        <option value="" selected>--Select Currency--</option>
                        <option value="CLP">CLP</option>
                        <option value="USD">USD</option>
                        <option value="ARS">ARS</option>
                        <option value="SOL">SOL</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('data.amount')}}</label>
                    <input type="number" min="1" class="form-control" required="" name="amount" id="local-amount">
                </div>
                <div class="form-group col-md-12">
                    <input type="submit" value="{{__('data.withdraw')}}" class="btn btn-success">
                </div>
            </form>
            <!--<form class="row" action="/withdraw_test" method="post" id="with-form" style="display:none;">-->
            <!--    @csrf-->
            <!--    <input type="hidden" name="bank" value="local_bank" />-->
            <!--    <div class="form-group col-md-6">-->
            <!--        <label>{{__('data.name')}}</label>-->
            <!--        <input type="text" value="{{ auth()->user()->name }}" class="form-control" required="" name="Name" disabled="disabled">-->
            <!--    </div>-->
            <!--    <div class="form-group col-md-6">-->
            <!--        <label>{{__('data.bankName')}}</label>-->
            <!--        <select name="bank_name" required="" class="form-control">-->
            <!--            @if(!is_null($local_bank))-->
            <!--                <option value="{{ $local_bank->getBank->bank_name }}" selected>{{ $local_bank->getBank->bank_name }}</option>-->
            <!--            @endif-->
            <!--            <option value="Banco BBVA">Banco BBVA</option>-->
            <!--            <option value="Banco BCI">Banco BCI</option>-->
            <!--            <option value="Banco BICE">Banco BICE</option>-->
            <!--            <option value="Banco Consorcio">Banco Consorcio</option>-->
            <!--            <option value="Banco Corpbanca">Banco Corpbanca</option>-->
            <!--            <option value="Banco de Chile (Edwards, Citi)">Banco de Chile (Edwards, Citi)</option>-->
            <!--            <option value="Banco Estado">Banco Estado</option>-->
            <!--            <option value="Banco Falabella">Banco Falabella</option>-->
            <!--            <option value="Banco ITAU">Banco ITAU</option>-->
            <!--            <option value="Banco Santander">Banco Santander</option>-->
            <!--            <option value="Banco Security">Banco Security</option>-->
            <!--            <option value="Banco Ripley">Banco Ripley</option>-->
            <!--            <option value="Banco Santander BANEFE">Banco Santander BANEFE</option>-->
            <!--            <option value="Banco Internacional">Banco Internacional</option>-->
            <!--            <option value="Scotiabank">Scotiabank</option>-->
            <!--        </select>-->
            <!--    </div>-->
             
            <!--    <div class="form-group col-md-6">-->
            <!--        <label>{{__('data.accoType')}}</label>-->
            <!--        <select name="account_type" required="" class="form-control">-->
            <!--            @if(!is_null($local_bank))-->
            <!--                <option value="{{ $local_bank->getBank->account_type }}" selected>{{ $local_bank->getBank->account_type }}</option>-->
            <!--            @endif-->
            <!--            <option value="Cuenta CORRIENTE">Cuenta CORRIENTE</option>-->
            <!--            <option value="Cuenta AHORROS">Cuenta AHORROS</option>-->
            <!--            <option value="Cuenta VISTA">Cuenta VISTA</option>-->
            <!--            <option value="Cuenta Chequera Electr贸nica">Cuenta Chequera Electr贸nica</option>-->
            <!--            <option value="Cuenta RUT">Cuenta RUT</option>-->
            <!--        </select>-->
            <!--    </div>-->
            
                
            <!--    <div class="form-group col-md-6">-->
            <!--        <label>{{__('data.bankAccountNumber')}}</label>-->
            <!--        <input type="text" class="form-control" required="" name="bank_account_number" value="{{ !is_null($local_bank) ? $local_bank->getBank->bank_account_number : '' }}">-->
            <!--    </div>-->
            <!--    <div class="form-group col-md-6">-->
            <!--        <label>{{__('data.currency')}}</label>-->
            <!--        <select class="form-control" name="currency" required="" id="local-currency">-->
            <!--            <option value="" selected>--Select Currency--</option>-->
            <!--            <option value="CLP">CLP</option>-->
            <!--            <option value="USD">USD</option>-->
            <!--            <option value="ARS">ARS</option>-->
            <!--            <option value="SOL">SOL</option>-->
            <!--        </select>-->
            <!--    </div>-->
            <!--    <div class="form-group col-md-6">-->
            <!--        <label>{{__('data.amount')}}</label>-->
            <!--        <input type="number" min="1" class="form-control" required="" name="amount" id="local-amount">-->
            <!--    </div>-->
            <!--    <div class="form-group col-md-12">-->
            <!--        <input type="submit" value="{{__('data.withdraw')}}" class="btn btn-success">-->
            <!--    </div>-->
            <!--</form>-->
            
            
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingTwo">
          <h2 class="mb-0">
            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              {{__('data.iBank')}}
            </button>
          </h2>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
          <div class="card-body">
            <form class="row" action="/withdraw" method="post" id="with-form">
                @csrf
                <input type="hidden" name="bank" value="international_bank" />
                <input type="hidden" name="type" value="{{ $param }}" />
                <div class="form-group col-md-6">
                    <label>{{__('data.name')}}</label>
                    <input type="text" value="{{ auth()->user()->name }}" class="form-control" required="" name="Name" disabled="disabled">
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('data.bankName')}}</label>
                    <input type="text" class="form-control" required="" name="bank_name" value="{{ !is_null($international_bank) ? $international_bank->getBank->bank_name : '' }}">
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('data.adress')}}</label>
                    <input type="text" class="form-control" required="" name="address" value="{{ !is_null($international_bank) ? $international_bank->getBank->address : '' }}">
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('data.city')}}</label>
                    <input type="text" class="form-control" required="" name="city" value="{{ !is_null($international_bank) ? $international_bank->getBank->city : '' }}">
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('data.country')}}</label>
                    <select name="country" required="" class="form-control">
                        @if(!is_null($international_bank))
                            <option value="{{ $international_bank->getBank->country }}" selected>{{ $international_bank->getBank->country }}</option>
                        @endif
                        <option value="United States">United States</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="Afghanistan">Afghanistan</option>
                        <option value="Albania">Albania</option>
                        <option value="Algeria">Algeria</option>
                        <option value="American Samoa">American Samoa</option>
                        <option value="Andorra">Andorra</option>
                        <option value="Angola">Angola</option>
                        <option value="Anguilla">Anguilla</option>
                        <option value="Antarctica">Antarctica</option>
                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                        <option value="Argentina">Argentina</option>
                        <option value="Armenia">Armenia</option>
                        <option value="Aruba">Aruba</option>
                        <option value="Australia">Australia</option>
                        <option value="Austria">Austria</option>
                        <option value="Azerbaijan">Azerbaijan</option>
                        <option value="Bahamas">Bahamas</option>
                        <option value="Bahrain">Bahrain</option>
                        <option value="Bangladesh">Bangladesh</option>
                        <option value="Barbados">Barbados</option>
                        <option value="Belarus">Belarus</option>
                        <option value="Belgium">Belgium</option>
                        <option value="Belize">Belize</option>
                        <option value="Benin">Benin</option>
                        <option value="Bermuda">Bermuda</option>
                        <option value="Bhutan">Bhutan</option>
                        <option value="Bolivia">Bolivia</option>
                        <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                        <option value="Botswana">Botswana</option>
                        <option value="Bouvet Island">Bouvet Island</option>
                        <option value="Brazil">Brazil</option>
                        <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                        <option value="Brunei Darussalam">Brunei Darussalam</option>
                        <option value="Bulgaria">Bulgaria</option>
                        <option value="Burkina Faso">Burkina Faso</option>
                        <option value="Burundi">Burundi</option>
                        <option value="Cambodia">Cambodia</option>
                        <option value="Cameroon">Cameroon</option>
                        <option value="Canada">Canada</option>
                        <option value="Cape Verde">Cape Verde</option>
                        <option value="Cayman Islands">Cayman Islands</option>
                        <option value="Central African Republic">Central African Republic</option>
                        <option value="Chad">Chad</option>
                        <option value="Chile">Chile</option>
                        <option value="China">China</option>
                        <option value="Christmas Island">Christmas Island</option>
                        <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                        <option value="Colombia">Colombia</option>
                        <option value="Comoros">Comoros</option>
                        <option value="Congo">Congo</option>
                        <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                        <option value="Cook Islands">Cook Islands</option>
                        <option value="Costa Rica">Costa Rica</option>
                        <option value="Cote D'ivoire">Cote D'ivoire</option>
                        <option value="Croatia">Croatia</option>
                        <option value="Cuba">Cuba</option>
                        <option value="Cyprus">Cyprus</option>
                        <option value="Czech Republic">Czech Republic</option>
                        <option value="Denmark">Denmark</option>
                        <option value="Djibouti">Djibouti</option>
                        <option value="Dominica">Dominica</option>
                        <option value="Dominican Republic">Dominican Republic</option>
                        <option value="Ecuador">Ecuador</option>
                        <option value="Egypt">Egypt</option>
                        <option value="El Salvador">El Salvador</option>
                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                        <option value="Eritrea">Eritrea</option>
                        <option value="Estonia">Estonia</option>
                        <option value="Ethiopia">Ethiopia</option>
                        <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                        <option value="Faroe Islands">Faroe Islands</option>
                        <option value="Fiji">Fiji</option>
                        <option value="Finland">Finland</option>
                        <option value="France">France</option>
                        <option value="French Guiana">French Guiana</option>
                        <option value="French Polynesia">French Polynesia</option>
                        <option value="French Southern Territories">French Southern Territories</option>
                        <option value="Gabon">Gabon</option>
                        <option value="Gambia">Gambia</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Germany">Germany</option>
                        <option value="Ghana">Ghana</option>
                        <option value="Gibraltar">Gibraltar</option>
                        <option value="Greece">Greece</option>
                        <option value="Greenland">Greenland</option>
                        <option value="Grenada">Grenada</option>
                        <option value="Guadeloupe">Guadeloupe</option>
                        <option value="Guam">Guam</option>
                        <option value="Guatemala">Guatemala</option>
                        <option value="Guinea">Guinea</option>
                        <option value="Guinea-bissau">Guinea-bissau</option>
                        <option value="Guyana">Guyana</option>
                        <option value="Haiti">Haiti</option>
                        <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                        <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                        <option value="Honduras">Honduras</option>
                        <option value="Hong Kong">Hong Kong</option>
                        <option value="Hungary">Hungary</option>
                        <option value="Iceland">Iceland</option>
                        <option value="India">India</option>
                        <option value="Indonesia">Indonesia</option>
                        <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                        <option value="Iraq">Iraq</option>
                        <option value="Ireland">Ireland</option>
                        <option value="Israel">Israel</option>
                        <option value="Italy">Italy</option>
                        <option value="Jamaica">Jamaica</option>
                        <option value="Japan">Japan</option>
                        <option value="Jordan">Jordan</option>
                        <option value="Kazakhstan">Kazakhstan</option>
                        <option value="Kenya">Kenya</option>
                        <option value="Kiribati">Kiribati</option>
                        <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                        <option value="Korea, Republic of">Korea, Republic of</option>
                        <option value="Kuwait">Kuwait</option>
                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                        <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                        <option value="Latvia">Latvia</option>
                        <option value="Lebanon">Lebanon</option>
                        <option value="Lesotho">Lesotho</option>
                        <option value="Liberia">Liberia</option>
                        <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                        <option value="Liechtenstein">Liechtenstein</option>
                        <option value="Lithuania">Lithuania</option>
                        <option value="Luxembourg">Luxembourg</option>
                        <option value="Macao">Macao</option>
                        <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                        <option value="Madagascar">Madagascar</option>
                        <option value="Malawi">Malawi</option>
                        <option value="Malaysia">Malaysia</option>
                        <option value="Maldives">Maldives</option>
                        <option value="Mali">Mali</option>
                        <option value="Malta">Malta</option>
                        <option value="Marshall Islands">Marshall Islands</option>
                        <option value="Martinique">Martinique</option>
                        <option value="Mauritania">Mauritania</option>
                        <option value="Mauritius">Mauritius</option>
                        <option value="Mayotte">Mayotte</option>
                        <option value="Mexico">Mexico</option>
                        <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                        <option value="Moldova, Republic of">Moldova, Republic of</option>
                        <option value="Monaco">Monaco</option>
                        <option value="Mongolia">Mongolia</option>
                        <option value="Montserrat">Montserrat</option>
                        <option value="Morocco">Morocco</option>
                        <option value="Mozambique">Mozambique</option>
                        <option value="Myanmar">Myanmar</option>
                        <option value="Namibia">Namibia</option>
                        <option value="Nauru">Nauru</option>
                        <option value="Nepal">Nepal</option>
                        <option value="Netherlands">Netherlands</option>
                        <option value="Netherlands Antilles">Netherlands Antilles</option>
                        <option value="New Caledonia">New Caledonia</option>
                        <option value="New Zealand">New Zealand</option>
                        <option value="Nicaragua">Nicaragua</option>
                        <option value="Niger">Niger</option>
                        <option value="Nigeria">Nigeria</option>
                        <option value="Niue">Niue</option>
                        <option value="Norfolk Island">Norfolk Island</option>
                        <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                        <option value="Norway">Norway</option>
                        <option value="Oman">Oman</option>
                        <option value="Pakistan">Pakistan</option>
                        <option value="Palau">Palau</option>
                        <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                        <option value="Panama">Panama</option>
                        <option value="Papua New Guinea">Papua New Guinea</option>
                        <option value="Paraguay">Paraguay</option>
                        <option value="Peru">Peru</option>
                        <option value="Philippines">Philippines</option>
                        <option value="Pitcairn">Pitcairn</option>
                        <option value="Poland">Poland</option>
                        <option value="Portugal">Portugal</option>
                        <option value="Puerto Rico">Puerto Rico</option>
                        <option value="Qatar">Qatar</option>
                        <option value="Reunion">Reunion</option>
                        <option value="Romania">Romania</option>
                        <option value="Russian Federation">Russian Federation</option>
                        <option value="Rwanda">Rwanda</option>
                        <option value="Saint Helena">Saint Helena</option>
                        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                        <option value="Saint Lucia">Saint Lucia</option>
                        <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                        <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                        <option value="Samoa">Samoa</option>
                        <option value="San Marino">San Marino</option>
                        <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                        <option value="Saudi Arabia">Saudi Arabia</option>
                        <option value="Senegal">Senegal</option>
                        <option value="Serbia and Montenegro">Serbia and Montenegro</option>
                        <option value="Seychelles">Seychelles</option>
                        <option value="Sierra Leone">Sierra Leone</option>
                        <option value="Singapore">Singapore</option>
                        <option value="Slovakia">Slovakia</option>
                        <option value="Slovenia">Slovenia</option>
                        <option value="Solomon Islands">Solomon Islands</option>
                        <option value="Somalia">Somalia</option>
                        <option value="South Africa">South Africa</option>
                        <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                        <option value="Spain">Spain</option>
                        <option value="Sri Lanka">Sri Lanka</option>
                        <option value="Sudan">Sudan</option>
                        <option value="Suriname">Suriname</option>
                        <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                        <option value="Swaziland">Swaziland</option>
                        <option value="Sweden">Sweden</option>
                        <option value="Switzerland">Switzerland</option>
                        <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                        <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                        <option value="Tajikistan">Tajikistan</option>
                        <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                        <option value="Thailand">Thailand</option>
                        <option value="Timor-leste">Timor-leste</option>
                        <option value="Togo">Togo</option>
                        <option value="Tokelau">Tokelau</option>
                        <option value="Tonga">Tonga</option>
                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                        <option value="Tunisia">Tunisia</option>
                        <option value="Turkey">Turkey</option>
                        <option value="Turkmenistan">Turkmenistan</option>
                        <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                        <option value="Tuvalu">Tuvalu</option>
                        <option value="Uganda">Uganda</option>
                        <option value="Ukraine">Ukraine</option>
                        <option value="United Arab Emirates">United Arab Emirates</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="United States">United States</option>
                        <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                        <option value="Uruguay">Uruguay</option>
                        <option value="Uzbekistan">Uzbekistan</option>
                        <option value="Vanuatu">Vanuatu</option>
                        <option value="Venezuela">Venezuela</option>
                        <option value="Viet Nam">Viet Nam</option>
                        <option value="Virgin Islands, British">Virgin Islands, British</option>
                        <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                        <option value="Wallis and Futuna">Wallis and Futuna</option>
                        <option value="Western Sahara">Western Sahara</option>
                        <option value="Yemen">Yemen</option>
                        <option value="Zambia">Zambia</option>
                        <option value="Zimbabwe">Zimbabwe</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('data.IBAN')}}</label>
                    <input type="text" class="form-control" required="" name="iban" value="{{ !is_null($international_bank) ? $international_bank->getBank->iban : '' }}">
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('data.swiftCode')}}</label>
                    <input type="text" class="form-control" required="" name="swift_code" value="{{ !is_null($international_bank) ? $international_bank->getBank->swift_code : '' }}">
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('data.accountTitle')}}</label>
                    <input type="text" class="form-control" required="" name="account_title" value="{{ !is_null($international_bank) ? $international_bank->getBank->account_title : '' }}">
                </div>

                <div class="form-group col-md-6">
                    <label>{{__('data.accountNumber')}}</label>
                    <input type="text" class="form-control" required="" name="account_number">
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('data.currency')}}</label>
                    <select class="form-control" name="currency" required="" id="international-currency">
                        <option value="" selected>--Select Currency--</option>
                        <option value="CLP">CLP</option>
                        <option value="USD">USD</option> 
                        <option value="ARS">ARS</option>
                        <option value="SOL">SOL</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>{{__('data.amount')}}</label>
                    <input type="number" min="1" class="form-control" required="" name="amount" id="international-amount">
                </div>
                <div class="form-group col-md-12">
                    <input type="submit" value="{{__('data.withdraw')}}" class="btn btn-success">
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> 
        
        $(document).ready(function(){
            $('#local-currency').on('change', function(){
                console.log($(this).val());
                var currency = $(this).val();
                
                switch (currency){
                    case 'USD':
                        $('#local-amount').attr('max', '{{ auth()->user()->wallet->usd }}');
                        break;
                    case 'ARS':
                        $('#local-amount').attr('max', '{{ auth()->user()->wallet->ars }}');
                        break;
                    case 'CLP':
                        $('#local-amount').attr('max', '{{ auth()->user()->wallet->clp }}');
                        break;
                    case 'SOL':
                        $('#local-amount').attr('max', '{{ auth()->user()->wallet->sol }}');
                        break;
                }
            });
            
            $('#international-currency').on('change', function(){
                console.log($(this).val());
                var currency = $(this).val();
                
                switch (currency){
                    case 'USD':
                        $('#international-amount').attr('max', '{{ auth()->user()->wallet->usd }}');
                        break;
                    case 'ARS':
                        $('#international-amount').attr('max', '{{ auth()->user()->wallet->ars }}');
                        break;
                    case 'CLP':
                        $('#international-amount').attr('max', '{{ auth()->user()->wallet->clp }}');
                        break;
                    case 'SOL':
                        $('#international-amount').attr('max', '{{ auth()->user()->wallet->sol }}');
                        break;
                }
            });
            $('#local-currency').trigger('change');
            $('#international-currency').trigger('change');
        });
    </script>
    <script>
        function getcountry(){
            var country= $('#getCountry option:selected').val();
            var bankSelect = document.getElementById("bankSelect");
            var optgroup = bankSelect.getElementsByTagName("optgroup");
            if(country.length){
                bankSelect.classList.remove("d-none");
            }
            for(i=0; i<optgroup.length; i++){
                optgroup[i].classList.add("d-none");
                console.log(optgroup[i].label);
                if(optgroup[i].label == country){
                    optgroup[i].classList.remove("d-none");  
                }
            }
        }
    </script>
@stop
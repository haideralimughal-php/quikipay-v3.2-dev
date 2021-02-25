{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{__('data.apiKey')}}</h1>
@stop

@section('content')
        <div class="text-center ">
            <button class="btn btn-info btn-lg show-btn">Show API Key</button>
           
            
            <div class="input-group my-3"  style="display:none" >
              <input id="apiKey"  class="form-control form-control-lg col-12 col-md-6 offset-md-3" type="text" value="{{ $apikey }}"   aria-describedby="basic-addon2">
              <div class="input-group-append">
                <span class="input-group-text "  id="basic-addon2" onclick="copyText()" data-toggle="tooltip" data-placement="top" title="Copy Key to Clipbooard" ><i class="fa fa-clipboard" aria-hidden="true"></i></span>
              </div>
            </div>
        </div>
        
    
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">

@stop

@section('js')
    <script> console.log('Hi!'); </script>
    
    <script>
    // This function is used to show the key input field...
    $('#basic-addon2').tooltip();
        $(document).ready(function(){
          $(".show-btn").click(function(){
            $(".input-group").show();
          });
    });
        
    // This function used to change the tooltip value...
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
      $('[data-toggle="tooltip"]').on('click', function() {
        $(this).attr('data-original-title', 'Key Copied.')
      });
    })
       
    // This function used to copy data to clipboard... 
    function copyText() {
      var copyText = document.getElementById("apiKey");
      copyText.select();
      copyText.setSelectionRange(0, 99999);
      document.execCommand("copy");
    }

           </script>

@stop
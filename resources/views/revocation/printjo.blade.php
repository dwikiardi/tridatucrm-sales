<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <style>

    body{
      /*font-family: Arial, Helvetica, sans-serif;*/
      /*font-family: "Calibri";*/
		font-family: 'Calibri Light', sans-serif;
    }
    @page {
      margin: 90px 50px 50px 50px;
    }
    .header_spjbtl{
      text-align:center;
    }
    .header_spjbtl h1{
      font-size:12px!important;
      margin:0!important;
      padding:0!important;
    }
    .header_spjbtl p, .body_spjbtl p,.body_spjbtl ol li{
      font-size:9px!important;
      margin:0!important;
      padding:0!important;
      line-height:1.2;
    }
    .body_spjbtl .asign{
      width:100%;
    }
    .body_spjbtl .asign td{
      font-size:9px!important;
      text-align:center;
    }
    h1{
      font-size:12px!important;
      padding:5px 0;
      margin:0;
    }
    .body_inv .heades{
      font-size:9px;
      width:100%;
    }
    .body_inv p{
      font-size:9px;
      margin-top:15px;
    }
    .body_inv .body_table{
      font-size:9px;
      width:calc(100% - 15px);
      margin-left:15px;
    }
    .body_inv .body_table td{
      font-size:9px;
      vertical-align:top;
    }
    .body_inv ol{
      font-size:9px;
      padding-left:15px;
      margin:0;
    }
    .body_inv .asign {
      width: 100%;
      text-align:center;
      font-size:9px;
    }
    .page_break { page-break-before: always; }
  </style>
  <title>Revocation Job Order</title>
</head>
<body>



<table class="heades" style="margin-bottom: 10px;width:100%;">
    <tr>
      <td width="30%">
      <table class="lside" style="margin-bottom: 10px;">
          <tr>
            <td><h1>PT. TRIDATU NETWORK</h1></td>
          </tr>
          <tr>
            <td>Jl. ...</td>
          </tr>
          <tr>
            <td>Telp : (0361) 12345678 </td>
          </tr>  
        </table>  
      </td>
      <td width="39%"></td>
      <td width="30%" style="text-align:center;vertical-align: top;">
      <table class="lside" style="margin-bottom: 10px;">
          <tr>
            <td>Denpasar, {{ date("d/M/Y",strtotime($revocation[0]->date))}}</td>
          </tr>
         
        </table>
      </td>
      </td>
    </tr>    
  </table>
<div class="body_inv">
  <table class="heades" style="margin-bottom: 10px;width:100%;">
    <tr>
      <td width="55%" style="vertical-align: top;">
        <table style="margin-bottom: 10px;width: 100%;">
          <tr>
            <td style="text-align: center;">
                <u>JOB ORDER REVOCATION</u><br>
                Nomor : {{$revocation[0]->notrans}}<br>

            </td>
          </tr>
         
        </table>
     
      </td>
    </tr>    
  </table>
  
  
  <table class="body_table" style="margin-bottom: 10px;width:100%;">
    <tr>
      <td width="40%">
        <table class="body" style="margin-bottom: 10px;width:100%;">
        <tr>
            <td width="30%">Property Name</td>
            <td width="10%">:</td>
            <td width="30%">{{$revocation[0]->contact}}</td>
          </tr>
          <tr>
            <td width="30%">Alamat</td>
            <td width="10%">:</td>
            <td width="30%">{{$revocation[0]->address}}, {{ $revocation[0]->city }} </td>
          </tr>
          <tr>
            <td width="30%">Contact </td>
            <td width="10%">:</td>
            <td width="30%">{{$revocation[0]->contact}} (mobile : {{$revocation[0]->mobile}})</td>
          </tr>    
        </table>
      </td>
      <td width="10%"></td>
      <td width="40%">
        <table class="body " style="margin-bottom: 10px;width:100%;">
          <tr>
            <td width="30%">Teckhnisi</td>
            <td width="10%">:</td>
            <td width="30%">{{$revocation[0]->teknisia}} {{$revocation[0]->teknisib}}</td>
          </tr>
          <tr>
            <td width="30%">IP Address</td>
            <td width="10%">:</td>
            <td width="30%">{{$revocation[0]->ips}}</td>
          </tr>
          <tr>
            <td width="30%">POPs</td>
            <td width="10%">:</td>
            <td width="30%">{{$revocation[0]->pops}}</td>
          </tr>
          <tr>
            <td width="30%">Package</td>
            <td width="10%">:</td>
            <td width="30%">{{$revocation[0]->services}}</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan=3>
        Installed
      </td>
    </tr>
    <tr>  
      <td colspan=3>
        <table class="body_table " style="margin-bottom: 10px;width:100%;">
          <tr>
            <td style=" border: solid 1px #000;">Stock Code</td>
            <td style=" border: solid 1px #000;">Name</td>
            <td style=" border: solid 1px #000;">Qty</td>
          </tr>
          @foreach($detail as $install)
          <tr>
              <td style=" border: solid 1px #000;">{{$install->stockcodename}}</td>
              <td style=" border: solid 1px #000;">{{$install->stockname}}</td>
              <td style=" border: solid 1px #000;">{{$install->qty}} {{$install->unit}}</td>
          </tr>
          @if($install->qtytype==1)
          <tr>
              
              <td colspan="3" style=" border: solid 1px #000;">
                  List Installed Serial Number : <br>
                  <?php
                  $serial=explode(',',$install->noseri);
                  foreach($serial as $noseri){
                      echo '[ ]'.$noseri.' &nbsp; &nbsp;';
                  }
                  ?>
              </td>
          </tr>
          @endif
          @endforeach        
        </table>
      </td>
    </tr>
    
  </table>
  
  

    
    <table class="asign" style="margin-bottom: 10px;width:100%;">
        
    <tr>
      <td width="30%"></td>
      <td width="39%"></td>
      <td width="30%">Denpasar, {{ date("d/M/Y",strtotime($revocation[0]->date))}}<br>PT. TRIDATU NETWORK <br><br><br><br>{{$revocation[0]->teknisia}} {{$revocation[0]->teknisib}}<br> (Technian)</td>
    </tr>
    
  </table>
</div>


</body>
</html>


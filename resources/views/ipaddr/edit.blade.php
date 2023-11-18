@extends('layouts/admin')
@section('title','Update IP Address')

@section('content_header')
<!-- <form action="{{ route('ipaddress.update') }}" method="POST">     -->
<form >    
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Update IP Address </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <a href="{{ url('ipaddress/view',$ipaddress[0])}}" class="btn btn-light">« Kembali</a>   
                        
          <button type="submit" class="btn btn-primary update">Update</button>
        </div>
      </div>
    </div>
@stop
@section('content')

@csrf
<div class="container-xl">
  <div class="row row-cards" data-masonry='{"percentPosition": true }'>
    <div class="col-12">
      <div class="card">
        <div class="card-header bg-blue-lt">
          <h3 class="card-title"> IP Address Information</h3>
        </div>
        <div class="card-body row">
        
          <div class="col-md-6">
            
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label"> Name</label>
              <div class="col">
                <input type="text" class="form-control" name="name" id="name" placeholder="POP Name" required value="{{$ipaddress[0]->name}}" readonly>
              </div>
            </div>
            
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Description</label>
              <div class="col">
              <textarea class="form-control" name="description" id="description" placeholder="">{{$ipaddress[0]->description}}</textarea>
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">IP Type</label>
              <div class="col">
                <select class="form-select" name="type" id='type'>
                <option value="1" 
                @if($ipaddress[0]->ip_type=="1")
                  selected
                @endif
                >Public</option>
                <option value="0"
                @if($ipaddress[0]->ip_type=="0")
                  selected
                @endif
                >Private</option>
                </select>
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Position</label>
              <div class="col">
                <select class="form-select" name="peruntukan" id='peruntukan'>
                <option value="">-- Choose One --</option>
                <option value="server"
                @if($ipaddress[0]->peruntukan=="server")
                  selected
                @endif
                >Server</option>
                <option value="pops"
                @if($ipaddress[0]->peruntukan=="pops")
                  selected
                @endif
                >POPs</option>
                <option value="leads"
                @if($ipaddress[0]->peruntukan=="leads")
                  selected
                @endif
                >Customer</option>
                </select>
              </div>
            </div>
              <div class="form-group mb-3 row leadid">
                <label class="form-label col-3 col-form-label">Customer</label>
                <div class="col">
                  <select class="form-select" name="leadid" id='leadid'>
                  <option value="">-- Choose One --</option>
                  @foreach($leads as $lead)
                  
                  <option value="{{$lead->id}}"
                  @if($ipaddress[0]->leads==$lead->id)
                    selected
                  @endif
                  >{{$lead->property_name}}</option>
                  @endforeach
                  </select>
                </div>
              </div>
            
            <div class="form-group mb-3 row popid">
                <label class="form-label col-3 col-form-label">Pops</label>
                <div class="col">
                  <select class="form-select" name="popid" id='popid'>
                  <option value="">-- Choose One --</option>
                  @foreach($pops as $pop)
                  
                  <option value="{{$lead->id}}"
                  @if($ipaddress[0]->pops==$pop->id)
                    selected
                  @endif
                  >{{$pop->name}}</option>
                  @endforeach
                  </select>
                </div>
              </div>
            </div>
            <input type="hidden" name="id" id="id" value="{{$ipaddress[0]->id}}">
            <input type="hidden" name="updatedbyid" id="updatedbyid" value="{{Auth::user()->id}}">
          </div>
          
        </div>
      </div>
    </div>
  </div> <!-- END Container-XL -->
</div>
  
<div class="container-xl">
  <!-- Page title -->
  <div class="page-header d-print-none">
    <div class="row align-items-center">
      <div class="col">
        <!-- Page pre-title -->
      </div>
      <!-- Page title actions -->
      <div class="col-auto ms-auto d-print-none"> 
        <a href="{{ url('ipaddress/view',$ipaddress[0])}}" class="btn btn-light">« Kembali</a>            
        <button type="submit" class="btn btn-primary update">Update</button>
      </div>
    </div>
  </div>
</div>
</form>
@stop
@push('js')

<script type="text/javascript">
  $(function () {
      $(document).ready(function() {
        var type= $('#peruntukan').find(":selected").val();
        console.log(type);
        switch (type) {
          case 'leads':
            $('.leadid').show();
            $('.popid').css("display", "none");
            break;
          case 'pops':
            $('.popid').show();
            $('.leadid').css("display", "none");
            break;
          default:
          $('.leadid').css("display", "none");
          $('.popid').css("display", "none");
            break;
        }
      });
      $('#peruntukan').on('change',function(){

        switch ($('#peruntukan').find(":selected").val()) {
          case 'leads':
            $('.leadid').show();
            $('.popid').css("display", "none");
            break;
          case 'pops':
            $('.popid').show();
            $('.leadid').css("display", "none");
            break;
          default:
          $('.leadid').css("display", "none");
          $('.popid').css("display", "none");
            break;
        }
      });
      $(document).on('click','.update',function (e) {
        var result=validate();
        if(result==true){
          
          let mydata ={
            "name" : $('#name').val(),
            "description" : $("#description").val(),
            "type" : $('#type').find(":selected").val(),
            "peruntukan" : $('#peruntukan').find(":selected").val(),
            "leadid" : $('#leadid').find(":selected").val(),
            "popid" : $('#popid').find(":selected").val(),
            "id" : $('#id').val(),
            "updatedbyid" : $("#updatedbyid").val()
          };
          console.log(mydata);
          $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
          });
          
          $.ajax({
            url: "{{route('ipaddress.update')}}",
            type: "POST",
            data: mydata,
            success: function( response ) {
               const obj = JSON.parse(response);
              if(obj.status ==="success"){
                window.location.href = obj.message;
              }
              if(obj.status ==="failed"){
                alert(obj.message);
              }
            }
          });
          return false;
        }else{
          return false;
        }
      });
    function validate(){
      var peruntukan= $('#peruntukan').find(":selected").val();
      var valid=true;
      if(peruntukan == 'leads' ){
        if($('#leadid').find(":selected").val()==""){
          alert("Please Choose Contact");
          valid=false;
        }
      }
      if(peruntukan == 'pops' ){
        if($('#popid').find(":selected").val()==""){
          alert("Please Choose Pop");
          valid=false;
        }
      }
      return valid;
    }
      
  });
</script>
@endpush
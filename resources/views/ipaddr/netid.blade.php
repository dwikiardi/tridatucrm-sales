@extends('layouts/admin')
@section('title','IP Address')
@section('add_css')
<style>
  .dataTables_filter{
    float: right;
    padding-right:15px;
  }
  .dataTables_length{
    padding-left:15px;
  }
  .dataTables_length label{
    display: inline-flex;
    padding: 5px;
  }
  .dataTables_length label select{
    margin: 0 5px;
  }
  .dataTables_info{
    padding: 5px 15px;
  }
  .hides{
    display:none;
  }
</style>
@stop
@section('content_header')
    
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">IP Address </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <div class="btn-list">
            <!-- <span class=" d-sm-inline">
              <a href="#" class="btn btn-white">
                New view
              </a>
            </span>-->
            <!-- <a href="{{ url('ipaddress/create')}}" class="btn btn-primary  d-sm-inline-block"> -->
            <a href="#" class="btn btn-primary  d-sm-inline-block Generate">
              <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
              Generate New Netwoek IP
            </a>
           
          </div>
        </div>
      </div>
    </div>
    <div class="page-header d-print-none hides creates">
    <div class="col-12">
        <div class="card">
          <div class="card-header bg-blue-lt">
            <h3 class="card-title"> Generate New Network Address</h3>
          </div>
          <div class="card-body row">
          <div class="col-md-6">
              
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">IP Address</label>
                <div class="col">
                  <input type="text" class="form-control" id="ipaddress" name="ipaddress" placeholder="xxx.xxx.xxx.xxx"/>
                </div>
              </div>
              
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">IP Type</label>
                <div class="col">
                  <select class="form-select" name="type" id='type'>
                  <option value="1">Public</option>
                  <option value="0">Private</option>
                  </select>
                </div>
              </div>


              
              <input type="hidden" name="createdbyid" value="{{Auth::user()->id}}">
              <input type="hidden" name="updatedbyid" value="{{Auth::user()->id}}">
            </div>
            <div class="col-md-6">
              
              <div class="form-group">
              <a href="#" class="btn btn-primary  d-sm-inline-block createNetwork">
                Generate 
              </a>
              </div>
              <br>
              <div class="form-group">
              <a href="#" class="btn btn-danger  d-sm-inline-block hidethis">
                Close 
              </a>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
@stop
@section('content')
<div class="container-xl">
    <div class="row row-deck row-cards">
        <div class="col-12">
          <div class="card">
           
            
            <div class="table-responsive"  style="min-height: 550px;">
              <table class="table card-table table-vcenter text-nowrap datatable">
                <thead>
                  <tr>
                    <th>Network IP</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
            
          </div>
        </div>
    </div>
</div>
@stop
@push('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
  $(function () {
    
    var table = $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 256,
        ajax: "{{ route('ipaddress.netid') }}",
        columns: [
            {data: 'Network', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                oData.Network.replace
                $(nTd).html("<a href='{{ url('ipaddress/')}}/"+oData.detail+"'>"+oData.Network+"</a>");
              }
            }
        ]
    });
    $(document).on("click",".edit",function(){
      var id=$(this).attr("data-id");
      console.log("click id: " + id);
      window.location.href = "{{ url('ipaddress/edit')}}/" + id;
    });
    $(document).on("click",".Generate",function(){
      $('.creates').removeClass('hides');
      $('.creates').addClass('show');
    });
    $(document).on("click",".hidethis",function(){
      $('.creates').removeClass('show');
      $('.creates').addClass('hides');
    });
    $(document).on("click",".createNetwork",function(){
      var ipadd=$('#ipaddress').val();
      var type= $('#type').find(":selected").val();
      var isvalid=validIP(ipadd);
      if(isvalid==true){
        //ajax check on database
        var mydata={
            'ipaddress' : ipadd
          };
        $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
          });
        $.ajax({
            url: "{{url('ipaddress/checkip')}}/" + ipadd,
            type: "GET",
            success: function( response ) {
              console.log(response);
              if (response!=0){
                alert("IP Network already exist!");
              }else{
                var result=generate(ipadd,type);
                //alert(result);
              }
              
            }
          });
      }else{
        alert("Invalid IP Address");
      }
    });
    function generate(param,type) {
      var mydata={'ip' : param,'type':type};
      $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
          });
        $.ajax({
            url: "{{route('ipaddress.store')}}",
            type: "POST",
            data: mydata,
            success: function( response ) {
              
              alert(response.msg);
              var filter= param.slice(0, param.lastIndexOf('.'));
              $('.dataTable').DataTable().search( filter ).draw();
            }
          });
    }
    function validIP(ipv4) {
      const regexExp = /^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/gi;
      let isItValidIP = regexExp.test(ipv4);

      console.log(isItValidIP); // true
      return isItValidIP
    }
  });
</script>
@endpush
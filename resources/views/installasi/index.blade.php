@extends('layouts/admin')
@section('title','Installasi')
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
</style>
@stop
@section('content_header')
    
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Installasi </h1>
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
            <a href="{{ url('installasi/create')}}" class="btn btn-primary  d-sm-inline-block">
              <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
              New Installasi
            </a>
           
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
                  
                    <th>Installasi No.</th>
                    <th>Date</th>
                    <th>Customer Property</th>
                    <th>By</th>
                    <th>Package</th>
                    <th>Note</th>
                    <th>Status</th>
                    
                    <th>Action</th>
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
        ajax: "{{ route('installasi.index') }}",
        columns: [
          {data: 'NoInstallation', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html(oData.NoInstallation);
              }
            },
            {data: 'Date', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html(oData.Date);
              }
            },
            {data: 'customer', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html(oData.customer);
              }
            },
            {data: 'InstallationBy', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html(oData.InstallationBy);
              }
            },
            {data: 'services', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html(oData.services);
              }
            },
            {data: 'Note', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html(oData.Note);
              }
            },
            {data: 'status', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html(oData.status);
              }
            },
            
            
             {data: 'action', name: 'action', installasiable: false, searchable: false},
        ]
    });
    $(document).on("click",".printjo",function(){
      var id=$(this).attr("data-id");
      console.log(id);
      $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
      });
      // $('.process').attr("disabled", true);

      $.ajax({
        url: "{{url('installasi/printjo')}}/" + id ,
        type: "GET",
        data: id,
        success: function( response ) {
          const obj = JSON.parse(response);
          if(obj.status ==="success"){
            window.open(obj.file,'_blank');
          }
          
        }
      });
    });
    $(document).on("click",".prininstal",function(){
      var id=$(this).attr("data-id");
      console.log(id);
      $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
      });
      // $('.process').attr("disabled", true);

      $.ajax({
        url: "{{url('installasi/installed')}}/" + id ,
        type: "GET",
        data: id,
        success: function( response ) {
          const obj = JSON.parse(response);
          if(obj.status ==="success"){
            window.open(obj.file,'_blank');
          }
          
        }
      });
    });
  });
</script>
@endpush
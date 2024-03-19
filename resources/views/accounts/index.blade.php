@extends('layouts/admin')
@section('title','Accounts')
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
</style>
@stop
@section('content_header')
    
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Accounts </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <div class="btn-list">
            
            <a href="{{ url('accounts/create')}}" class="btn btn-primary  d-sm-inline-block">
              
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
              New Accounts
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
                    <th>Account</th>
                    <th>Property</th>
                    <th>Package</th>
                    <th>Price</th>
                    <th>POP</th>
                    <th>Owner</th>
                    <!-- <th>Action</th> -->
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
        ajax: "{{ route('accounts.index') }}",
        columns: [
            {data: 'accname', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html("<a href='{{ url('accounts/view')}}/"+oData.accid+"'>"+oData.accname+"</a>");
              }
            },
            {data: 'property', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html("<a href='{{ url('contacts/view')}}/"+oData.prid+"'>"+oData.property+"</a>");
              }
            },
            {data: 'package', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                if(oData.package == '-'){
                  $(nTd).html("-");
                }else{
                  $(nTd).html("<a href='{{ url('services/view')}}/"+oData.svid+"'>"+oData.package+"</a>");
                }
                
              }
            },
            {data: 'price', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                if(oData.price <= 0){
                  $(nTd).html("-");
                }else{
                  $(nTd).html("<a href='{{ url('services/view')}}/"+oData.svid+"'>"+oData.price+"</a>");
                }
                
              }
            },
            {data: 'pop_name', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
            {
              if(oData.pop_name == '-'){
                $(nTd).html("-");
              }else{
                $(nTd).html("<a href='{{ url('pops/view')}}/"+oData.popid+"'>"+oData.pop_name+"</a>");
              }
              
            }},
            {data: 'owner', name: 'owner'},
            // {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    // $(document).on("click",".edit",function(){
    //   var id=$(this).attr("data-id");
    //   console.log("click id: " + id);
    //   window.location.href = "{{ url('accounts/edit')}}/" + id;
    // });
  });
</script>
@endpush
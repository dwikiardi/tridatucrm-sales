@extends('layouts/admin')
@section('title','Products')
@section('add_css');
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
          <h1 class="m-0 text-dark">Products </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <div class="btn-list">
            <!-- <span class="d-none d-sm-inline">
              <a href="#" class="btn btn-white">
                New view
              </a>
            </span>-->
            <a href="{{ url('products/create')}}" class="btn btn-primary d-none d-sm-inline-block">
              <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
              New Products
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
                    <th>Name</th>
                    <th>Description</th>
                    <th>Have SN</th>
                    <th>Price</th>
                    <th>Note</th>
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
        ajax: "{{ route('products.index') }}",
        columns: [
            {data: 'Name', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html("<a href='{{ url('products/view')}}/"+oData.ID+"'>"+oData.Name+"</a>");
              }
            },
            {data: 'Description', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html("<a href='{{ url('products/view')}}/"+oData.ID+"'>"+oData.Description+"</a>");
              }},
              {data: 'Serial', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html("<a href='{{ url('products/view')}}/"+oData.ID+"'>"+oData.Serial+"</a>");
              }},
            {data: 'Price', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html("<a href='{{ url('products/view')}}/"+oData.ID+"'>"+oData.Price+"</a>");
              }},
            {data: 'Note', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html("<a href='{{ url('products/view')}}/"+oData.ID+"'>"+oData.Note+"</a>");
              }}
        ]
    });
    $(document).on("click",".edit",function(){
      var id=$(this).attr("data-id");
      console.log("click id: " + id);
      window.location.href = "{{ url('products/edit')}}/" + id;
    });
  });
</script>
@endpush
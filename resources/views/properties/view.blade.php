@extends('layouts/admin')
@section('title',' Detail Property ')
@section('add_css')
<style>
.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{
  color: #fff;
  background-color: #206bc4;
}
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
            <ul class="nav nav-tabs" data-bs-toggle="tabs" style=" margin-bottom: 15px; border-bottom: none;">
              <li class="nav-item" style="margin-right: 15px;">
                <a href="#tabs-home-17" class="nav-link active" data-bs-toggle="tab" style="border: solid #cbd5e1 1px!important;border-radius: 15px;">Overview</a>
              </li>
              <li class="nav-item">
                <a href="#tabs-profile-17" class="nav-link" data-bs-toggle="tab" style="border: solid #cbd5e1 1px!important;border-radius: 15px;">Timeline</a>
              </li>
            </ul>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <a href="{{ url('properties')}}" class="btn btn-light">« Kembali</a>   
          <a href="{{ url('properties/edit',$properties[0]->id)}}" class="btn btn-primary d-none d-sm-inline-block" >
             Update Property
            </a>  
        </div>
      </div>
    </div>
@stop
@section('content')
<div class="container-xl">
  <div class="row row-cards">
    <div class="col-12">

      
      <div class="tab-content">
        <div class="tab-pane fade active show" id="tabs-home-17">
          <div class="container-xl" style="padding: 0!important;">
            <div class="row row-cards" data-masonry='{"percentPosition": true }'>
              <div class="col-12 col-md-6">
                <div class="card col-12">
                  <div class="card-header ">
                    <h3 class="card-title"> Account Information </h3>
                    <div class="col-auto ms-auto d-print-none"> 
                        <a class="btn btn-light" data-bs-toggle="collapse" href="#infowrap" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-bottombar-collapse" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M20 6v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2z"></path>
                            <path d="M20 15h-16"></path>
                            <path d="M14 8l-2 2l-2 -2"></path>
                          </svg>
                        </a>   
                      </div>
                  </div>
                  <div class="card-body row collapse multi-collapse show" id="infowrap">
                    <div class="col-md-12">
                      <div class="form-group mb-12 row">
                        <label class="form-label col-6 col-form-label">Account Name</label>
                        <div class="col" style="padding: 10px!important;">
                        {{ $accounts[0]->fullname }}
                        </div>
                      </div>
                      <div class="form-group mb-12 row">
                        <label class="form-label col-6 col-form-label">Address</label>
                        <div class="col" style="padding: 10px!important;">
                        {{ $accounts[0]->address }}, {{ $accounts[0]->city }},{{ $accounts[0]->province }},{{ $accounts[0]->country }}
                        </div>
                      </div>
                      <div class="form-group mb-12 row">
                        <label class="form-label col-6 col-form-label">Mobile</label>
                        <div class="col" style="padding: 10px!important;">
                        {{ $accounts[0]->mobile }}
                        </div>
                      </div>
                      <div class="form-group col-6 row">
                        <a href="{{ url('accounts/view',$accounts[0]->id)}}" class="btn btn-light">« Kembali ke Account</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="card col-12">
                  <div class="card-header ">
                    <h3 class="card-title"> Contact Information </h3>
                    <div class="col-auto ms-auto d-print-none"> 
                        <a class="btn btn-light" data-bs-toggle="collapse" href="#infowrap" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-bottombar-collapse" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M20 6v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2z"></path>
                            <path d="M20 15h-16"></path>
                            <path d="M14 8l-2 2l-2 -2"></path>
                          </svg>
                        </a>   
                    </div>
                  </div>
                  <div class="card-body row collapse multi-collapse show" id="infowrap">
                    <div class="col-md-12">
                      <div class="form-group mb-12 row">
                        <label class="form-label col-6 col-form-label">Contact Name</label>
                        <div class="col" style="padding: 10px!important;">
                        {{ $contacts[0]->contactname }}
                        </div>
                      </div>
                      <div class="form-group mb-12 row">
                        <label class="form-label col-6 col-form-label">Address</label>
                        <div class="col" style="padding: 10px!important;">
                        {{ $contacts[0]->address }}, {{ $contacts[0]->city }},{{ $contacts[0]->province }},{{ $contacts[0]->country }}
                        </div>
                      </div>
                      <div class="form-group mb-12 row">
                        <label class="form-label col-6 col-form-label">Mobile</label>
                        <div class="col" style="padding: 10px!important;">
                        {{ $contacts[0]->mobile }}
                        </div>
                      </div>
                      <div class="form-group col-6 row">
                        <a href="{{ url('contacts/view',$contacts[0]->id)}}" class="btn btn-light">« Kembali ke Contact</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="card">
                  <div class="card-header ">
                    <h3 class="card-title"> Propery Information </h3>
                    <div class="col-auto ms-auto d-print-none"> 
                      <a class="btn btn-light" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-bottombar-collapse" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                          <path d="M20 6v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2z"></path>
                          <path d="M20 15h-16"></path>
                          <path d="M14 8l-2 2l-2 -2"></path>
                        </svg>
                      </a>   
                    </div>
                  </div>
                  
                  <div class="card-body row collapse multi-collapse show" id="multiCollapseExample1">
                    
                  <div class="col-md-6">
                    <div class="form-group mb-3 row">
                      <label class="form-label col-3 col-form-label">Property Owner</label>
                      <div class="col" style="padding: 10px!important;">
                        {{ $owner[0]->first_name }} {{ $owner[0]->last_name }}
                      </div>
                    </div>
                    <div class="form-group mb-3 row">
                      <label class="form-label col-3 col-form-label">Account </label>
                      <div class="col" style="padding: 10px!important;">
                        {{ $accounts[0]->fullname }}
                      </div>
                    </div>
                    <div class="form-group mb-3 row">
                      <label class="form-label col-3 col-form-label">Contact </label>
                      <div class="col" style="padding: 10px!important;">
                        {{ $contacts[0]->contactname }}
                      </div>
                    </div>
                    <div class="form-group mb-3 row">
                      <label class="form-label col-3 col-form-label">Property Name</label>
                      <div class="col" style="padding: 10px!important;">
                        {{ $properties[0]->propertyname }}
                      </div>
                    </div>
                    <div class="form-group mb-3 row">
                      <label class="form-label col-3 col-form-label">Address</label>
                      <div class="col" style="padding: 10px!important;">
                        {{ $properties[0]->address }}
                      </div>
                    </div>  
                    <div class="form-group mb-3 row">
                      <label class="form-label col-3 col-form-label">City</label>
                      <div class="col" style="padding: 10px!important;">
                        {{ $properties[0]->city }}
                      </div>
                    </div>
                    <div class="form-group mb-3 row">
                      <label class="form-label col-3 col-form-label">State/Province</label>
                      <div class="col" style="padding: 10px!important;">
                        {{ $properties[0]->province }}
                      </div>
                    </div>  
                    <div class="form-group mb-3 row">
                      <label class="form-label col-3 col-form-label">Country</label>
                      <div class="col" style="padding: 10px!important;">
                        {{ $properties[0]->country }}
                      </div>
                    </div>  
                    <div class="form-group mb-3 row">
                      <label class="form-label col-3 col-form-label">ZIP Code</label>
                      <div class="col" style="padding: 10px!important;">
                        {{ $properties[0]->zipcode }}
                      </div>
                    </div>  
                    <div class="form-group mb-3 row">
                      <label class="form-label col-3 col-form-label">Mobile</label>
                      <div class="col" style="padding: 10px!important;">
                        {{ $properties[0]->mobile }}
                      </div>
                    </div> 
                    <div class="form-group mb-3 row">
                      <label class="form-label col-3 col-form-label">Phone</label>
                      <div class="col" style="padding: 10px!important;">
                        {{ $properties[0]->phone }}
                      </div>
                    </div>  
                    <div class="form-group mb-3 row">
                      <label class="form-label col-3 col-form-label">FAX</label>
                      <div class="col" style="padding: 10px!important;">
                        {{ $properties[0]->fax }}
                      </div>
                    </div>  
                  </div>
                  <div class="col-md-6">
                    <div class="form-group mb-3 row">
                      <label class="form-label col-3 col-form-label">E-mail</label>
                      <div class="col" style="padding: 10px!important;">
                        {{ $properties[0]->email }}
                      </div>
                    </div>  
                      
                    <div class="form-group mb-3 row">
                      <label class="form-label col-3 col-form-label">Google Map Url</label>
                      <div class="col" style="padding: 10px!important;">
                        {{ $properties[0]->mapurl }}
                      </div>
                    </div>  
                    <div class="form-group mb-3 row">
                      <label class="form-label col-3 col-form-label">Map Latitude</label>
                      <div class="col" style="padding: 10px!important;">
                        {{ $properties[0]->maplat }}
                      </div>
                    </div> 
                    <div class="form-group mb-3 row">
                      <label class="form-label col-3 col-form-label">Map Longitude</label>
                      <div class="col" style="padding: 10px!important;">
                        {{ $properties[0]->maplong }}
                      </div>
                    </div>
                    <div class="form-group mb-3 row">
                      <label class="form-label col-3 col-form-label">Package Request</label>
                      <div class="col" style="padding: 10px!important;">
                        {{ $product }}
                      </div>
                    </div>
                    <div class="form-group mb-3 row">
                      <label class="form-label col-3 col-form-label">Note</label>
                      <div class="col" style="padding: 10px!important;">
                        {{ $properties[0]->note }}
                      </div>
                    </div>  
                    
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
                  <a href="{{ url('properties')}}" class="btn btn-light">« Kembali</a>   
                  <a href="{{ url('properties/edit',$properties[0]->id)}}" class="btn btn-primary d-none d-sm-inline-block" >
                    Update Property
                  </a> 
                </div>
              </div>
            </div>
          </div>

          
        </div>
        <div class="tab-pane fade" id="tabs-profile-17">
        <div class="col-12">
          <div class="card">
            <div class="card-header bg-blue-lt">
              <h3 class="card-title"> History </h3>
            </div>
            <div class="card-body row">
              <ul class="list list-timeline">
                @foreach($logs as $log)
                <li>
                  <div class="list-timeline-icon"><!-- Download SVG icon from http://tabler-icons.io/i/brand-twitter -->
                    <!-- SVG icon code -->
                    @if (strpos($log->subject, 'Create') !== FALSE)
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                        <path d="M9 12l6 0"></path>
                        <path d="M12 9l0 6"></path>
                      </svg>
                    @endif
                    @if (strpos($log->subject, 'Update') !== FALSE)
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path>
                        <path d="M13.5 6.5l4 4"></path>
                      </svg>
                    @endif
                    
                    
                  </div>
                  <div class="list-timeline-content">
                    <div class="list-timeline-time">{{ $log->created_at }}</div>
                    <p class="list-timeline-title">{{$log->subject}}</p>
                    <p class="text-muted">{{ $log->firstname }} {{ $log->lastname }}</p>
                  </div>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
        </div>
        
      </div>
    </div>
  </div>
</div>
@stop
@push('js')
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
        ajax: "{{ route('accounts.contact',$accounts[0]->id) }}",
        columns: [
            {data: 'ID', name: 'ID'},
            {data: 'Name', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html("<a href='{{ url('contacts/view')}}/"+oData.ID+"'>"+oData.Name+"</a>");
              }
            },
            {data: 'Email', name: 'Email'},
            {data: 'Mobile', name: 'Mobile'},
            {data: 'Phone', name: 'Phone'},
            {data: 'Owners', name: 'Owners'}
        ]
    });
    $(document).on("click",".edit",function(){
      var id=$(this).attr("data-id");
      console.log("click id: " + id);
      window.location.href = "{{ url('accounts/edit')}}/" + id;
    });
  });
</script>
@endpush
@endpush
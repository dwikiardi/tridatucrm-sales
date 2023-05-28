@extends('layouts/admin')
@section('title','Create New Leads')
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
          <a href="{{ url('leads')}}" class="btn btn-light">« Kembali</a>  
          <a href="{{ url('leads/convert',$leads[0]->id)}}" class="btn btn-success d-none d-sm-inline-block" >
             Convert to Accounts
          </a>  
          <a href="{{ url('leads/edit',$leads[0]->id)}}" class="btn btn-primary d-none d-sm-inline-block" >
             Update Lead
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
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header ">
                          <h3 class="card-title"> Lead Information </h3>
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
                              <label class="form-label col-3 col-form-label">Lead Owner</label>
                              <div class="col" style="padding: 10px!important;">
                              {{ $owner[0]->first_name }} {{ $owner[0]->last_name }}
                              </div>
                            </div>    
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">Lead Name</label>
                              <div class="col" style="padding: 10px!important;">
                              {{ $leads[0]->leadsname }}
                              </div>
                            </div>
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">First Name</label>
                              <div class="col" style="padding: 10px!important;">
                              {{ $leads[0]->first_name }}
                              </div>
                            </div>
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">Lead Name</label>
                              <div class="col" style="padding: 10px!important;">
                              {{ $leads[0]->last_name }}
                              </div>
                            </div>
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">E-mail</label>
                              <div class="col" style="padding: 10px!important;">
                              {{ $leads[0]->email }}
                              </div>
                            </div>  
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">Website</label>
                              <div class="col" style="padding: 10px!important;">
                              {{ $leads[0]->website }}
                              </div>
                            </div>  
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">Phone</label>
                              <div class="col" style="padding: 10px!important;">
                              {{ $leads[0]->phone }}
                              </div>
                            </div>  
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">FAX</label>
                              <div class="col" style="padding: 10px!important;">
                              {{ $leads[0]->fax }}
                              </div>
                            </div>  
                          </div>
                          <div class="col-md-6">
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">Company Name</label>
                              <div class="col" style="padding: 10px!important;">
                              {{ $leads[0]->company }}
                              </div>
                            </div>  
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">Lead Type</label>
                              <div class="col" style="padding: 10px!important;">
                              @switch($leads[0]->leadstatus)
                                @case(1)
                                Future Contact
                                  @break
                                @case(2)
                                  Tobe Contact
                                  @break
                                @case(3)
                                  Contacted
                                  @break
                                @case(4)
                                  Waiting for Response
                                  @break
                                @case(5)
                                  Cannot be Contacted
                                  @break
                                @default
                                  None
                              @endswitch
                              </div>
                              
                            </div> 
                            
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">Note</label>
                              <div class="col" style="padding: 10px!important;">
                              {{ $leads[0]->note }}
                              </div>
                            </div>  
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">Created By</label>
                              <div class="col" style="padding: 10px!important;">
                              {{ $createbyid[0]->first_name}} {{ $createbyid[0]->last_name}}
                              <br>{{ $leads[0]->created_at }}
                              </div>
                            </div>  
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">Last Modified By</label>
                              <div class="col" style="padding: 10px!important;">
                              {{ $updatebyid[0]->first_name}} {{ $updatebyid[0]->last_name}}
                              <br>{{ $leads[0]->updated_at }}
                              </div>
                            </div> 
                          </div>
                        
                          
                          <div class="card-header ">
                            <h3 class="card-title"> Address Information </h3>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">Address</label>
                              <div class="col" style="padding: 10px!important;">
                              {{ $leads[0]->address }}
                              </div>
                            </div>  
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">City</label>
                              <div class="col" style="padding: 10px!important;">
                              {{ $leads[0]->city }}
                              </div>
                            </div>
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">State/Province</label>
                              <div class="col" style="padding: 10px!important;">
                              {{ $leads[0]->province }}
                              </div>
                            </div>  
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">Country</label>
                              <div class="col" style="padding: 10px!important;">
                              {{ $leads[0]->country }}
                              </div>
                            </div>  
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">ZIP Code</label>
                              <div class="col" style="padding: 10px!important;">
                              {{ $leads[0]->zipcode }}
                              </div>
                            </div>  
                            
                            
                          </div>
                          <div class="col-md-6">
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">Deskription</label>
                              <div class="col">
                              {{$leads[0]->description}}
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
                    <a href="{{ url('leads')}}" class="btn btn-light">« Kembali</a>   
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
      
  
  });
</script>
@endpush
@endpush
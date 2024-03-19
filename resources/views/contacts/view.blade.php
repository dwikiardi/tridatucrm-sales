@extends('layouts/admin')
@section('title','Create New Contacts')
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
  .col-form-label{
    padding-top:0!important;
    padding-bottom:0!important;
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
          <a href="{{ url('contacts')}}" class="btn btn-light">« Kembali</a>  
          
          <a href="{{ url('contacts/edit',$leads[0]->id)}}" class="btn btn-primary  d-sm-inline-block" >
             Update Contacts
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
                      <div class="card-header bg-blue-lt">
                        <h3 class="card-title"> Accounts's Information</h3>
                        <div class="col-auto ms-auto d-print-none"> 
                            <a class="btn btn-light" data-bs-toggle="collapse" href="#c1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-bottombar-collapse" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M20 6v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2z"></path>
                                <path d="M20 15h-16"></path>
                                <path d="M14 8l-2 2l-2 -2"></path>
                              </svg>
                            </a>   
                          </div>
                        </div>
                       
                        <div class="card-body row collapse multi-collapse show" id="c1">
                        <div class="col-md-6">
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Contact Owner</label>
                            <div class="col">
                            {{$owner[0]->first_name}} {{$owner[0]->last_name}}
                            </div>
                          </div>    
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Contact Name</label>
                            <div class="col">
                              {{$leads[0]->leadsname}}
                            </div>
                          </div>
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Account Name</label>
                            <div class="col">
                            <a href="{{url('accounts/view')}}/{{$Accounts[0]->id}}">{{$Accounts[0]->account_name}}</a>
                            </div>
                          </div>
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Account Address</label>
                            <div class="col">
                            
                            {{$Accounts[0]->address}}
                            </div>
                          </div>  
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Account City</label>
                            <div class="col">
                              
                              {{$Accounts[0]->city}}
                            </div>
                          </div>
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Account State/Province</label>
                            <div class="col">
                              
                              {{$Accounts[0]->state}}
                            </div>
                          </div>  
                          
                          <input type="hidden" name="accountid" id="accountid" value="{{$leads[0]->accountid}}">
                          <input type="hidden" name="createbyid" value="{{Auth::user()->id}}">
                          <input type="hidden" name="updatebyid" value="{{Auth::user()->id}}">
                        </div>
                        <div class="col-md-6">
                          
                          
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Account Country</label>
                            <div class="col">
                              
                              {{$Accounts[0]->country}}
                            </div>
                          </div>  
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Account ZIP Code</label>
                            <div class="col">
                              
                              {{$Accounts[0]->zipcode}}
                            </div>
                          </div>
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Account E-mail</label>
                            <div class="col">
                              
                              {{$Accounts[0]->email}}
                            </div>
                          </div>  
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Account Website</label>
                            <div class="col">
                              
                              {{$Accounts[0]->website}}
                            </div>
                          </div>  
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Account Phone</label>
                            <div class="col">
                              
                              {{$Accounts[0]->phone}}
                            </div>
                          </div> 
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="card">
                      <div class="card-header bg-blue-lt">
                        <h3 class="card-title"> Billing's Information</h3>
                        <div class="col-auto ms-auto d-print-none"> 
                            <a class="btn btn-light" data-bs-toggle="collapse" href="#c1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-bottombar-collapse" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M20 6v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2z"></path>
                                <path d="M20 15h-16"></path>
                                <path d="M14 8l-2 2l-2 -2"></path>
                              </svg>
                            </a>   
                          </div>
                        </div>
                       
                        <div class="card-body row collapse multi-collapse show" id="c1">
                        
                        <div class="col-md-6">
                           
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Contact Billing Address</label>
                            <div class="col">
                            
                            {{$leads[0]->billing_address}}
                            </div>
                          </div>  
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Billing City</label>
                            <div class="col">
                              
                              {{$leads[0]->billing_city}}
                            </div>
                          </div>
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Billing State/Province</label>
                            <div class="col">
                              
                              {{$leads[0]->billing_state}}
                            </div>
                          </div>  
                          
                        </div>
                        <div class="col-md-6">
                           
                          
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Billing Country</label>
                            <div class="col">
                              
                              {{$leads[0]->billing_country}}
                            </div>
                          </div>  
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Billing ZIP Code</label>
                            <div class="col">
                              
                              {{$leads[0]->billing_zipcode}}
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="card">
                      <div class="card-header bg-blue-lt">
                        <h3 class="card-title"> Contact Information</h3>
                        <div class="col-auto ms-auto d-print-none"> 
                            <a class="btn btn-light" data-bs-toggle="collapse" href="#c2" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-bottombar-collapse" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M20 6v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2z"></path>
                                <path d="M20 15h-16"></path>
                                <path d="M14 8l-2 2l-2 -2"></path>
                              </svg>
                            </a>   
                          </div>
                        </div>
                       
                        <div class="card-body row collapse multi-collapse show" id="c2">
                        <div class="col-md-6">
                          
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">PIC Name</label>
                            <div class="col">
                              
                              {{$leads[0]->pic_contact}}
                            </div>
                          </div>
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">PIC E-Mail</label>
                            <div class="col">
                              
                              {{$leads[0]->pic_email}}
                            </div>
                          </div>  
                          
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">PIC Mobile</label>
                            <div class="col">
                              
                              {{$leads[0]->pic_mobile}}
                            </div>
                          </div>  
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">PIC Phone</label>
                            <div class="col">
                              
                              {{$leads[0]->pic_phone}}
                            </div>
                          </div>
                          
                        </div>
                        <div class="col-md-6">
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Billing Name</label>
                            <div class="col">
                              
                              {{$leads[0]->billing_contact}}
                            </div>
                          </div>
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Billing E-Mail</label>
                            <div class="col">
                              
                              {{$leads[0]->billing_email}}
                            </div>
                          </div>  
                          
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Billing Mobile</label>
                            <div class="col">
                              
                              {{$leads[0]->billing_mobile}}
                            </div>
                          </div>  
                          <div class="form-group mb-3 row">
                            <label class="form-label col-3 col-form-label">Billing Phone</label>
                            <div class="col">
                              
                              {{$leads[0]->billing_phone}}
                            </div>
                          </div>
                          
                          
                        </div>
                      </div>
                     
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="card">
                      <div class="card-header bg-blue-lt">
                        <h3 class="card-title"> Property Information </h3>
                        <div class="col-auto ms-auto d-print-none"> 
                            <a class="btn btn-light" data-bs-toggle="collapse" href="#c3" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-bottombar-collapse" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M20 6v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2z"></path>
                                <path d="M20 15h-16"></path>
                                <path d="M14 8l-2 2l-2 -2"></path>
                              </svg>
                            </a>   
                          </div>
                        </div>
                       
                        <div class="card-body row collapse multi-collapse show" id="c3">
                          <div class="col-md-6">
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">Property Name</label>
                              <div class="col">
                              {{$leads[0]->property_name}}
                              </div>
                            </div> 
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">Property Address</label>
                              <div class="col">
                              
                              {{$leads[0]->property_address}}
                              </div>
                            </div>  
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">Property City</label>
                              <div class="col">
                                
                                {{$leads[0]->property_city}}
                              </div>
                            </div>
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">Property State/Province</label>
                              <div class="col">
                                
                                {{$leads[0]->property_state}}
                              </div>
                            </div>  
                            
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">Property Country</label>
                              <div class="col">
                                
                                {{$leads[0]->property_country}}
                              </div>
                            </div>  
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">Property ZIP Code</label>
                              <div class="col">
                                
                                {{$leads[0]->property_zipcode}}
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">Map Latitude</label>
                              <div class="col">
                              {{$leads[0]->maplat}}
                              </div>
                            </div>  
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">Map Longitude</label>
                              <div class="col">
                              {{$leads[0]->maplong}}
                              </div>
                            </div>  
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">Google Map URL</label>
                              <div class="col">
                              {{$leads[0]->gmapurl}}
                              </div>
                            </div>
                          
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">Lead Status</label>
                              <div class="col">
                              {{$leads[0]->status}}
                              </div>
                            </div> 
                            <div class="form-group mb-3 row">
                              <label class="form-label col-3 col-form-label">Note</label>
                              <div class="col">
                              
                              {{$leads[0]->note}}
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
                        </div>
                        
                      
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="card">
                      <div class="card-header bg-blue-lt">
                        <h3 class="card-title"> Quote History </h3>
                        <div class="col-auto ms-auto d-print-none"> 
                            <a href="{{route('quotes.create',$leads[0]->id)}}" class="btn btn-success  d-sm-inline-block" >
                              Create Quote
                            </a>  
                            <a class="btn btn-light" data-bs-toggle="collapse" href="#c4" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-bottombar-collapse" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M20 6v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2z"></path>
                                <path d="M20 15h-16"></path>
                                <path d="M14 8l-2 2l-2 -2"></path>
                              </svg>
                            </a>   
                          </div>
                        </div>
                       
                        <div class="card-body row collapse multi-collapse show" id="c4">
                          <div class="col-md-12">
                            <div class="table-responsive"  style="min-height: 150px;">
                              <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                  <tr>
                                    <th>Quote No.</th>
                                    <th>Date</th>
                                    <th>To</th>
                                    <th>Approve</th>
                                    <th>Status</th>
                                    <th>Owners</th>
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
                  <div class="col-12">
                    <div class="card">
                      <div class="card-header bg-blue-lt">
                        <h3 class="card-title"> Surveys History </h3>
                        <div class="col-auto ms-auto d-print-none"> 
                            <a href="{{route('surveys.create',$leads[0]->id)}}" class="btn btn-success  d-sm-inline-block" >
                              Request Survey
                            </a>  
                            <a class="btn btn-light" data-bs-toggle="collapse" href="#s1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-bottombar-collapse" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M20 6v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2z"></path>
                                <path d="M20 15h-16"></path>
                                <path d="M14 8l-2 2l-2 -2"></path>
                              </svg>
                            </a>   
                          </div>
                        </div>
                       
                        <div class="card-body row collapse multi-collapse show" id="s1">
                          <div class="col-md-12">
                            <div class="table-responsive"  style="min-height: 150px;">
                              <table class="table card-table table-vcenter text-nowrap survey">
                                <thead>
                                  <tr>
                                    <th>Property Name</th>
                                    <th>Requesta Date</th>
                                    <th>Survey Date </th>
                                    <th>Process By</th>
                                    <th>Status</th>
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
                  <div class="col-12">
                    <div class="card">
                      <div class="card-header bg-blue-lt">
                        <h3 class="card-title"> Instalation </h3>
                        <div class="col-auto ms-auto d-print-none"> 
                            <a class="btn btn-light" data-bs-toggle="collapse" href="#c5" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-bottombar-collapse" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M20 6v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2z"></path>
                                <path d="M20 15h-16"></path>
                                <path d="M14 8l-2 2l-2 -2"></path>
                              </svg>
                            </a>   
                          </div>
                        </div>
                       
                        <div class="card-body row collapse multi-collapse show" id="c5">
                        <div class="col-md-12">
                          
                          
                        </div>
                        
                      </div>
                      
                    
                  </div>
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
              </div></div>
              
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
                          @if (strpos($log->logname, 'Create') !== FALSE)
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                              <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                              <path d="M9 12l6 0"></path>
                              <path d="M12 9l0 6"></path>
                            </svg>
                          @endif
                          @if (strpos($log->logname, 'Update') !== FALSE)
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                              <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path>
                              <path d="M13.5 6.5l4 4"></path>
                            </svg>
                          @endif
                          @if (strpos($log->logname, 'Convert') !== FALSE)
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-transform-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                              <path d="M18 14a4 4 0 1 1 -3.995 4.2l-.005 -.2l.005 -.2a4 4 0 0 1 3.995 -3.8z" stroke-width="0" fill="currentColor"></path>
                              <path d="M16.707 2.293a1 1 0 0 1 .083 1.32l-.083 .094l-1.293 1.293h3.586a3 3 0 0 1 2.995 2.824l.005 .176v3a1 1 0 0 1 -1.993 .117l-.007 -.117v-3a1 1 0 0 0 -.883 -.993l-.117 -.007h-3.585l1.292 1.293a1 1 0 0 1 -1.32 1.497l-.094 -.083l-3 -3a.98 .98 0 0 1 -.28 -.872l.036 -.146l.04 -.104c.058 -.126 .14 -.24 .245 -.334l2.959 -2.958a1 1 0 0 1 1.414 0z" stroke-width="0" fill="currentColor"></path>
                              <path d="M3 12a1 1 0 0 1 .993 .883l.007 .117v3a1 1 0 0 0 .883 .993l.117 .007h3.585l-1.292 -1.293a1 1 0 0 1 -.083 -1.32l.083 -.094a1 1 0 0 1 1.32 -.083l.094 .083l3 3a.98 .98 0 0 1 .28 .872l-.036 .146l-.04 .104a1.02 1.02 0 0 1 -.245 .334l-2.959 2.958a1 1 0 0 1 -1.497 -1.32l.083 -.094l1.291 -1.293h-3.584a3 3 0 0 1 -2.995 -2.824l-.005 -.176v-3a1 1 0 0 1 1 -1z" stroke-width="0" fill="currentColor"></path>
                              <path d="M6 2a4 4 0 1 1 -3.995 4.2l-.005 -.2l.005 -.2a4 4 0 0 1 3.995 -3.8z" stroke-width="0" fill="currentColor"></path>
                            </svg>
                          @endif
                          
                        </div>
                        <div class="list-timeline-content">
                          <div class="list-timeline-time">{{ $log->created_at }}</div>
                          <p class="list-timeline-title">{{$log->logname}}</p>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
  $(function () {
    var URI = "{{ url('/') }}";
    var quote = $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('leads.getquote',$leads[0]->id) }}",
        columns: [
            {data: 'QuoteNo', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html("<a href='{{ url('quotes/view')}}/"+oData.ID+"'>"+oData.QuoteNo+"</a>");
              }
            },
            {data: 'Date', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html("<a href='{{ url('quotes/view')}}/"+oData.ID+"'>"+oData.Date+"</a>");
              }
            },
            {data: 'To', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html("<a href='{{ url('quotes/view')}}/"+oData.ID+"'>"+oData.To+"</a>");
              }
            },
            {data: 'Approve', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html("<a href='{{ url('quotes/view')}}/"+oData.ID+"'>"+oData.Approve+"</a>");
              }
            },
            {data: 'Status', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html("<a href='{{ url('quotes/view')}}/"+oData.ID+"'>"+oData.Status+"</a>");
              }
            },
            {data: 'Owners', name: 'Owners'},
            // {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    var survey = $('.survey').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('leads.getsurvey',$leads[0]->id) }}",
        columns: [
            {data: 'Property', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html("<a href='{{ url('surveys/view')}}/"+oData.ID+"'>"+oData.Property+"</a>");
              }
            },
            {data: 'ReqDate', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html("<a href='{{ url('surveys/view')}}/"+oData.ID+"'>"+oData.ReqDate+"</a>");
              }
            },
            {data: 'SurveyDate', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html("<a href='{{ url('surveys/view')}}/"+oData.ID+"'>"+oData.SurveyDate+"</a>");
              }
            },
            {data: 'Petugas', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html("<a href='{{ url('surveys/view')}}/"+oData.ID+"'>"+oData.Petugas+"</a>");
              }
            },
            {data: 'Status', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html("<a href='{{ url('surveys/view')}}/"+oData.ID+"'>"+oData.Status+"</a>");
              }
            },
            {data: 'Note', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) 
              {
                $(nTd).html("<a href='{{ url('surveys/view')}}/"+oData.ID+"'>"+oData.Note+"</a>");
              }
            }
            // {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });
</script>
@endpush
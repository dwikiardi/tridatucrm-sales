@extends('layouts/admin')
@section('title','Create New Surveys')

@section('content_header')
<form action="{{ route('surveys.store') }}" method="POST">    
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Create New Survey </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <a href="{{ url('surveys')}}" class="btn btn-light">« Kembali</a>                 
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </div>
@stop
@section('content')

@csrf
<div class="container-xl">
  <div class="row row-cards" data-masonry='{"percentPosition": true }'>
    <div class="col-md-6">
      <div class="card">
        <div class="card-header bg-blue-lt">
          <h3 class="card-title"> Survey Request</h3>
        </div>
        <div class="card-body row">
          <div class="col-12" style="padding:0 15px;"> 
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Request Date</label>
              <div class="col">
                <div class='input-group date' id='datetimepicker' >
                    <input type='text' name='requestdate' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Request To</label>
              <div class="col">
                    <select class="form-select" name="surveyorto">
                      @foreach($Users as $user)
                        @if($user->id=== Auth::user()->id)
                          <option selected value="{{ $user->id }}">{{ $user->first_name}} {{ $user->last_name}}</option>
                        @else
                          <option  value="{{ $user->id }}">{{ $user->first_name}} {{ $user->last_name}}</option>
                        @endif
                      @endforeach
                    </select>
              </div>
            </div>    
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Lead/ Contact</label>
              <div class="col">
                    <select class="form-select" name="leadid">
                      @foreach($Leads as $lead)
                      <?php
                        if(is_null($lead->leadsname)){$name=$lead->property_name;}else{ $name=$lead->leadsname; }
                        
                      ?>
                        <!-- <option  value="{{ $lead->id }}">{{ $lead->leadsname}}</option> -->
                        @if($lead->id==$id)
                            <option selected value="{{ $lead->id }}">{{ $name }}</option>
                          @else
                            <option  value="{{ $lead->id }}">{{ $name }}</option>
                          @endif
                      @endforeach
                    </select>
              </div>
            </div>    
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Survey Status</label>
              <div class="col">
                <select class="form-select" name="status">
                  <option  value="open" selected>Open</option>
                  <option  value="onproggress">On Proggress</option>
                  <option  value="close">Close</option>
                  <option  value="canceled">Canceled</option>
                </select>
              </div>
            </div>   
            
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Note</label>
              <div class="col">
              <textarea class="form-control" name="note" placeholder=""></textarea>
              </div>
            </div>  
            
            <input type="hidden" name="createdbyid" value="{{Auth::user()->id}}">
            <input type="hidden" name="updatedbyid" value="{{Auth::user()->id}}">
          </div>
          
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-header bg-blue-lt">
          <h3 class="card-title"> Survey Result</h3>
        </div>
        <div class="card-body row">
          <div class="col-12" style="padding:0 15px;">
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Survey Date</label>
              <div class="col">
              <div class='input-group date' id='datetimepicker' >
                    <input type='text' name='surveydate' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Survey To</label>
              <div class="col">
                    <select class="form-select" name="surveyorid">
                      @foreach($Users as $user)
                        @if($user->id=== Auth::user()->id)
                          <option selected value="{{ $user->id }}">{{ $user->first_name}} {{ $user->last_name}}</option>
                        @else
                          <option  value="{{ $user->id }}">{{ $user->first_name}} {{ $user->last_name}}</option>
                        @endif
                      @endforeach
                    </select>
              </div>
            </div>   
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Location Latitude</label>
              <div class="col">
                <input type="text" class="form-control" name="rmaplat" placeholder="">
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Location Longitude</label>
              <div class="col">
                <input type="text" class="form-control" name="rmaplong" placeholder="">
              </div>
            </div>
            
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Survey Result</label>
              <div class="col">
              <textarea class="form-control" name="note" placeholder=""></textarea>
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
      <a href="{{ url('surveys')}}" class="btn btn-light">« Kembali</a>                 
          <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </div>
  </div>
</div>
</form>
@stop
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
<script type="text/javascript">
  $(function () {
    $('.date').datetimepicker({format: 'DD/MM/YYYY'});
      
  });
</script>
@endpush
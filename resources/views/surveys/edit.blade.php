@extends('layouts/admin')
@section('title','Update Surveys')

@section('content_header')
<form action="{{ route('surveys.update') }}" method="POST">    
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Update Survey </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <a href="{{ url('surveys/view',$surveys[0])}}" class="btn btn-light">« Kembali</a>   
                        
          <button type="submit" class="btn btn-primary">Update</button>
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
                    <input type='text' name='requestdate' class="form-control"  value="{{date('d/m/Y',strtotime($surveys[0]->requestdate))}}">
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
                        @if($user->id=== $surveys[0]->surveyorto)
                          <option selected value="{{ $user->id }}">{{ $user->first_name}} {{ $user->last_name}}</option>
                        @else
                          <option  value="{{ $user->id }}">{{ $user->first_name}} {{ $user->last_name}}</option>
                        @endif
                      @endforeach
                    </select>
              </div>
            </div>    
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Lead</label>
              <div class="col">
                    <select class="form-select" name="leadid">
                      @foreach($Leads as $lead)
                        @if($lead->id == $surveys[0]->leadid)
                          <option selected value="{{ $lead->id }}">{{ $lead->leadsname}}</option>
                        @else
                          <option  value="{{ $lead->id }}">{{ $lead->leadsname}}</option>
                        @endif
                        
                      @endforeach
                    </select>
              </div>
            </div>    
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Status</label>
              <div class="col">
                <select class="form-select" name="status">
                  <option 
                  @if( $surveys[0]->status==="open")
                    selected 
                  @endif
                  value="open" selected>Open</option>
                  <option 
                  @if( $surveys[0]->status==="onproggress")
                    selected 
                  @endif
                  value="onproggress">On Proggress</option>
                  <option 
                  @if( $surveys[0]->status==="close")
                    selected 
                  @endif
                   value="close">Close</option>
                  <option 
                  @if( $surveys[0]->status==="canceled")
                    selected 
                  @endif
                   value="canceled">Canceled</option>
                </select>
              </div>
            </div>   
            
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Note</label>
              <div class="col">
              <textarea class="form-control" name="note" placeholder="">{{$surveys[0]->note}}</textarea>
              </div>
            </div>  
            
            <input type="hidden" name="id" value="{{$surveys[0]->id}}">
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
                    <input type='text' name='surveydate' class="form-control"  value="{{date('d/m/Y',strtotime($surveys[0]->requestdate))}}">
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
                        @if($user->id=== $surveys[0]->surveyorid)
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
                <input type="text" class="form-control" name="rmaplat" placeholder="" value="{{$surveys[0]->rmaplat}}">
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Location Longitude</label>
              <div class="col">
                <input type="text" class="form-control" name="rmaplong" placeholder="" value="{{$surveys[0]->rmaplong}}">
              </div>
            </div>
            
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Survey Result</label>
              <div class="col">
              <textarea class="form-control" name="surveyresult" placeholder="">{{$surveys[0]->surveyresult}}</textarea>
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
        <a href="{{ url('surveys/view',$surveys[0])}}" class="btn btn-light">« Kembali</a>            
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </div>
  </div>
</div>
</form>
@stop
@push('js')

<script type="text/javascript">
  $(function () {
      
   
      
  });
</script>
@endpush
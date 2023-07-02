@extends('layouts/admin')
@section('title','Update Meetings')

@section('content_header')
  
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Update Lead </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
       
      </div>
    </div>
@stop
@section('content')
<form action="{{ route('meetings.update') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="container-xl">
  <!-- Page title -->
  <div class="page-header d-print-none">
    <div class="row align-items-center">
      <div class="col">
        <!-- Page pre-title -->
      </div>
      <!-- Page title actions -->
      <div class="col-auto ms-auto d-print-none"> 
      <a href="{{ route('meetings.view',$meetings[0]->id)}}" class="btn btn-light">« Kembali</a>                 
          <button class="btn btn-primary simpan">Simpan</button>
      </div>
    </div>
  </div>
</div>
<div class="container-xl">
  <div class="row row-cards" data-masonry='{"percentPosition": true }'>
    <div class="col-12">
        <div class="card">
          <div class="card-header bg-blue-lt">
            <h3 class="card-title"> Meetings Information</h3>
          </div>
          <div class="card-body row">
            <div class="col-md-6">
              
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Meeting Name</label>
                <div class="col">
                  <input type="text" class="form-control" name="meetingname" placeholder="Meeting Name" value="{{$meetings[0]->meetingname}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Lead</label>
                <div class="col">
                      <select class="form-select" name="leadid">
                        @foreach($Leads as $lead)
                          @if($lead->id==$meetings[0]->leadid)
                            <option selected value="{{ $lead->id }}">{{ $lead->leadsname}}</option>
                          @else
                            <option  value="{{ $lead->id }}">{{ $lead->leadsname}}</option>
                          @endif
                        @endforeach
                      </select>
                </div>
              </div>    
              
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Meeting Start</label>
                <div class="col-md-6">
                  <div class="input-icon mb-2">
                    <input class="form-control date" placeholder="Select a date" id="datetimepicker" name="startdate" value="{{date('d/m/Y',strtotime($meetings[0]->startdate))}}"/>
                    <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="5" width="16" height="16" rx="2" /><line x1="16" y1="3" x2="16" y2="7" /><line x1="8" y1="3" x2="8" y2="7" /><line x1="4" y1="11" x2="20" y2="11" /><line x1="11" y1="15" x2="12" y2="15" /><line x1="12" y1="15" x2="12" y2="18" /></svg>
                    </span>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="input-icon mb-2">
                    <input class="form-control time" placeholder="Select a Time" id="datetimepicker" name="starttime" value="{{$meetings[0]->starttime}}"/>
                  </div>
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Meeting End</label>
                <div class="col-md-6">
                  <div class="input-icon mb-2">
                    <input class="form-control date" placeholder="Select a date" id="datetimepicker" name="enddate" value="{{date('d/m/Y',strtotime($meetings[0]->enddate))}}"/>
                    <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="5" width="16" height="16" rx="2" /><line x1="16" y1="3" x2="16" y2="7" /><line x1="8" y1="3" x2="8" y2="7" /><line x1="4" y1="11" x2="20" y2="11" /><line x1="11" y1="15" x2="12" y2="15" /><line x1="12" y1="15" x2="12" y2="18" /></svg>
                    </span>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="input-icon mb-2">
                    <input class="form-control time" placeholder="Select a Time" id="datetimepicker" name="endtime" value="{{$meetings[0]->endtime}}"/>
                  </div>
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Locations</label>
                <div class="col">
                <textarea class="form-control" name="location" placeholder="">{{$meetings[0]->location}}</textarea>
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Host By</label>
                <div class="col">
                      <select class="form-select" name="host">
                        @foreach($Users as $user)
                          @if($user->id=== $meetings[0]->host)
                            <option selected value="{{ $user->id }}">{{ $user->first_name}} {{ $user->last_name}}</option>
                          @else
                            <option  value="{{ $user->id }}">{{ $user->first_name}} {{ $user->last_name}}</option>
                          @endif
                        @endforeach
                      </select>
                </div>
              </div>
              
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Detail Meeting</label>
                <div class="col">
                <textarea class="form-control" name="detail" placeholder="">{{$meetings[0]->detail}}</textarea>
                </div>
              </div>  
              
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Meeting Result</label>
                <div class="col">
                <textarea class="form-control" name="result" placeholder="">{{$meetings[0]->result}}</textarea>
                </div>
              </div>  
              <input type="hidden" name="reminder" value="0">
              <input type="hidden" name="updatedbyid" value="{{Auth::user()->id}}">
            </div>
            <div class="col-md-6">
              <div class="form-group mb-12 row">
                <label class="form-label col-12 col-form-label">Meeting Partisipants</label>
              </div>  
              <input type="hidden" name="list" class="form-control list" value="{{$meetingpart->count()}}" >
              <input type="hidden" name="id" class="form-control list" value="{{$meetings[0]->id}}" >
              <table  class="table table-hover table-bordered table-stripped" id="example2">
                <thead>
                    <tr>
                      <th class="text-center">Name</th>
                      <th class="text-center">Email</th>
                      <th class="text-center" width="115px"></th>
                    </tr>
                </thead>
                <tbody class="details" id="details">
                  @foreach($meetingpart as $part)
                    <tr>
                      <td><input type="text" name="name[]" class="form-control " value="{{$part->name}}"></td>
                      <td><input type="email" name="email[]" class="form-control "  value="{{$part->email}}"></td>
                      <td>
                        <span class="btn btn-success btn-sm addlist">
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                            <path d="M9 12l6 0"></path>
                            <path d="M12 9l0 6"></path>
                          </svg>
                        </span>
                        <span class="btn btn-danger btn-sm remlist">  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M18 6l-12 12"></path><path d="M6 6l12 12"></path></svg></span>
                      </td>
                    </tr>
                  @endforeach
                  
                </tbody>
                
              </table>
              
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
      <a href="{{ route('meetings.view',$meetings[0]->id)}}" class="btn btn-light">« Kembali</a>                           
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
    $('#datetimepicker').datetimepicker({format: 'DD/MM/YYYY'});
   
      
  });
</script>
@endpush
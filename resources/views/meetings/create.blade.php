@extends('layouts/admin')
@section('title','Create New Meetings')

@section('content_header')

    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Create New Quote </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        
      </div>
    </div>
@stop
@section('content')

<form action="{{ route('meetings.store') }}" method="POST" id="myForm">
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
      <a href="{{ url('meetings')}}" class="btn btn-light">« Kembali</a>                 
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
            <h3 class="card-title"> Meeting Information</h3>
          </div>
          <div class="card-body row">
            <div class="col-md-6">
             
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Meeting Name</label>
                <div class="col">
                  <input type="text" class="form-control" name="meetingname" placeholder="Meeting Name">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Lead</label>
                <div class="col">
                      <select class="form-select" name="leadid">
                        @foreach($Leads as $lead)
                          @if($lead->id==$id)
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
                    <input class="form-control date" placeholder="Select a date" id="datetimepicker" name="startdate" value=""/>
                    <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="5" width="16" height="16" rx="2" /><line x1="16" y1="3" x2="16" y2="7" /><line x1="8" y1="3" x2="8" y2="7" /><line x1="4" y1="11" x2="20" y2="11" /><line x1="11" y1="15" x2="12" y2="15" /><line x1="12" y1="15" x2="12" y2="18" /></svg>
                    </span>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="input-icon mb-2">
                    <input class="form-control time" placeholder="Select a Time" id="datetimepicker" name="starttime" value=""/>
                  </div>
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Meeting End</label>
                <div class="col-md-6">
                  <div class="input-icon mb-2">
                    <input class="form-control date" placeholder="Select a date" id="datetimepicker" name="enddate" value=""/>
                    <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="5" width="16" height="16" rx="2" /><line x1="16" y1="3" x2="16" y2="7" /><line x1="8" y1="3" x2="8" y2="7" /><line x1="4" y1="11" x2="20" y2="11" /><line x1="11" y1="15" x2="12" y2="15" /><line x1="12" y1="15" x2="12" y2="18" /></svg>
                    </span>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="input-icon mb-2">
                    <input class="form-control time" placeholder="Select a Time" id="datetimepicker" name="endtime" value=""/>
                  </div>
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Locations</label>
                <div class="col">
                <textarea class="form-control" name="location" placeholder=""></textarea>
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Host By</label>
                <div class="col">
                      <select class="form-select" name="host">
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
                <label class="form-label col-3 col-form-label">Detail Meeting</label>
                <div class="col">
                <textarea class="form-control" name="detail" placeholder=""></textarea>
                </div>
              </div>  
              
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Meeting Result</label>
                <div class="col">
                <textarea class="form-control" name="result" placeholder=""></textarea>
                </div>
              </div>  
              <input type="hidden" name="reminder" value="0">
              <input type="hidden" name="createdbyid" value="{{Auth::user()->id}}">
              <input type="hidden" name="updatedbyid" value="{{Auth::user()->id}}">
            </div>
            <div class="col-md-6">
              <div class="form-group mb-12 row">
                <label class="form-label col-12 col-form-label">Meeting Partisipants</label>
              </div>  
              <input type="hidden" name="list" class="form-control list" value="1" >
              <table  class="table table-hover table-bordered table-stripped" id="example2">
                <thead>
                    <tr>
                      <th class="text-center">Name</th>
                      <th class="text-center">Email</th>
                      <th class="text-center" width="115px"></th>
                    </tr>
                </thead>
                <tbody class="details" id="details">
                  <tr>
                    <td><input type="text" name="name[]" class="form-control " ></td>
                    <td><input type="email" name="email[]" class="form-control " ></td>
                    <td>
                      <span class="btn btn-success btn-sm addlist">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                          <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                          <path d="M9 12l6 0"></path>
                          <path d="M12 9l0 6"></path>
                        </svg>
                      </span>
                    </td>
                </tr>
                </tbody>
                
              </table>
              
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
      <a href="{{ url('meetings')}}" class="btn btn-light">« Kembali</a>                 
          <button class="btn btn-primary simpan">Simpan</button>
      </div>
    </div>
  </div>
</div>
</form>
@stop
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- <script src="http://code.jquery.com/jquery-1.9.0.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>


<script type="text/javascript">
(function($) {
  $(document).ready(function() {
    $('.date').datetimepicker({format: 'DD/MM/YYYY'});
    $('.time').timepicker({
      timeFormat: 'h:mm p',
      interval: 60,
      minTime: '00',
      maxTime: '23:00pm',
      defaultTime: '8',
      startTime: '00:00',
      dynamic: false,
      dropdown: true,
      scrollbar: true
    });
  
    $(document).on('click', '.addlist', function () {
        //alert("Adding List");
        var all=parseInt($(".list").val()) + 1;
        //console.log(all);
        
        $(".list").val(all);
        
        var texts='<tr><td><input type="text" name="name[]" value=""  class="form-control "/></td><td><input type="email" name="email[]"  class="form-control subtotal" ></td><td><span class="btn btn-success btn-sm addlist"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path><path d="M9 12l6 0"></path><path d="M12 9l0 6"></path></svg></span><span class="btn btn-danger btn-sm remlist">  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M18 6l-12 12"></path><path d="M6 6l12 12"></path></svg></span></td></tr>';
        
        $(".details").append(texts);
        
    });
    
    $(document).on('click', '.remlist', function (e) {
      //e.preventDefault();
        $(this).parent().parent().remove();
    });
    $(document).on('click', '.simpan', function (e) {
      //e.preventDefault();
      var x=$('#myForm').serialize();
      console.log(x);
      //$('#myForm').submit();
    });
  });
})(jQuery);
</script>
@endpush
@extends('adminlte::page')

@section('title', '営業日カレンダー - Storemap')

@section('content_header')
<h1>{{$s_name}} / @lang('calendar.title')</h1>
@stop

@section('content')

@include('calendar.modal-calendar')
@include('calendar.modal-fastEvents')

<div class="row">
  <div class="col-md-3">
    <div class="sticky-top mb-3">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">@lang('calendar.draggable_events')</h4>
        </div>
        <div class="card-body">
          <!-- the events -->

          <div id='external-events-list'>
            @if($fastEvents)
            @foreach($fastEvents as $fastEvent)
            <div class='external-event fc-event
                @if($fastEvent->color == ' #007bff') bg-primary @elseif($fastEvent->color == '#ffc107')
              bg-warning
              @elseif($fastEvent->color == '#28a745')
              bg-success
              @elseif($fastEvent->color == '#dc3545')
              bg-danger
              @elseif($fastEvent->color == '#6c757d')
              bg-secondary
              @endif
              '
              data-event='{"id":"{{ $fastEvent->id }}","title":"{{ $fastEvent->title }}","color":"{{ $fastEvent->color }}","start":"{{ $fastEvent->start }}","end":"{{ $fastEvent->end }}","store_id":"{{ $sid }}"}'>{{ $fastEvent->title }}
            </div>
            @endforeach
            @endif
            <div class="checkbox">
              <input type='checkbox' id='drop-remove' />
              <label for='drop-remove'>@lang('calendar.remove_drop')</label>

              </p>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">@lang('calendar.submit_event')</h3>
        </div>
        <div class="card-body">
          <button class="btn btn-block btn-sm btn-outline-info w-100"
            id="newFastEvent">@lang('calendar.create_event')</button>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">@lang('calendar.example')</h3>
        </div>
        <div class="card-body">
          <ul class="list-unstyled">
            <li class="mb-1"><button class="btn btn-sm btn-primary w-100">@lang('calendar.primary')</button></li>
            <li class="mb-1"><button class="btn btn-sm btn-warning w-100">@lang('calendar.warning')</button></li>
            <li class="mb-1"><button class="btn btn-sm btn-success w-100">@lang('calendar.success')</button></li>
            <li class="mb-1"><button class="btn btn-sm btn-danger w-100">@lang('calendar.danger')</button></li>
            <li><button class="btn btn-sm btn-secondary w-100">@lang('calendar.secondary')</button></li>
          </ul>
        </div>
      </div>

    </div>
  </div>
  <!-- /.col -->
  <div class="col-md-9">
    <div class="card card-primary">
      <div class="card-body p-0">
        <!-- THE CALENDAR -->
        <!-- <div class="btn-group" style="width: 100%; margin-bottom: 10px;"> -->
        <div id='calendar' data-route-load-events="{{ route('routeLoadEvents', $sid) }}"
          data-route-event-update="{{ route('routeEventUpdate', $sid) }}"
          data-route-event-store="{{ route('routeEventStore') }}"
          data-route-event-delete="{{ route('routeEventDelete') }}"
          data-route-fast-event-delete="{{ route('routeFastEventDelete') }}"
          data-route-fast-event-update="{{ route('routeFastEventUpdate') }}"
          data-route-fast-event-store="{{ route('routeFastEventStore') }}" class="fc fc-ltr fc-bootstrap"></div>
        <!-- <div style='clear:both'></div> -->
        <!-- </div> -->
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
@stop

@section('css')
<link href="{{asset('css/fullcalendar/core/main.css')}}" rel='stylesheet' />
<link href="{{asset('css/fullcalendar/daygrid/main.css')}}" rel='stylesheet' />
<link href="{{asset('css/fullcalendar/timegrid/main.css')}}" rel='stylesheet' />
<link href="{{asset('css/fullcalendar/list/main.css')}}" rel='stylesheet' />
<link href="{{asset('css/fullcalendar/style.css')}}" rel='stylesheet' />
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
<script src="{{asset('js/fullcalendar/core/main.js')}}"></script>
<script src="{{asset('js/fullcalendar/interaction/main.js')}}"></script>
<script src="{{asset('js/fullcalendar/daygrid/main.js')}}"></script>
<script src="{{asset('js/fullcalendar/timegrid/main.js')}}"></script>
<script src="{{asset('js/fullcalendar/list/main.js')}}"></script>
<script src="{{asset('js/fullcalendar/core/locales-all.js')}}"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script src="{{asset('js/fullcalendar/jquery.mask.min.js')}}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script> --}}

<script>
  let objCalendar;
</script>
<script src="{{asset('js/fullcalendar/script.js')}}"></script>
<script src="{{asset('js/fullcalendar/calendar.js')}}"></script>
@stop
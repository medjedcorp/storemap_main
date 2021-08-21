@extends('adminlte::page')

@section('title', '営業日カレンダー - Storemap')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0"><i class="far fa-calendar-alt"></i> @lang('store.index.title')</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item active">@lang('store.index.title')</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div>
@stop

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">
        <div class="sticky-top mb-3">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">Draggable Events</h4>
            </div>
            <div class="card-body">
              <!-- the events -->
              <div id="external-events">
                <div class="external-event bg-success">Lunch</div>
                <div class="external-event bg-warning">Go home</div>
                <div class="external-event bg-info">Do homework</div>
                <div class="external-event bg-primary">Work on UI design</div>
                <div class="external-event bg-danger">Sleep tight</div>
                <div class="checkbox">
                  <label for="drop-remove">
                    <input type="checkbox" id="drop-remove">
                    remove after drop
                  </label>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Create Event</h3>
            </div>
            <div class="card-body">
              <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                <!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
                <ul class="fc-color-picker" id="color-chooser">
                  <li><a class="text-primary" href="#"><i class="fas fa-square"></i></a></li>
                  <li><a class="text-warning" href="#"><i class="fas fa-square"></i></a></li>
                  <li><a class="text-success" href="#"><i class="fas fa-square"></i></a></li>
                  <li><a class="text-danger" href="#"><i class="fas fa-square"></i></a></li>
                  <li><a class="text-muted" href="#"><i class="fas fa-square"></i></a></li>
                </ul>
              </div>
              <!-- /btn-group -->
              <div class="input-group">
                <input id="new-event" type="text" class="form-control" placeholder="Event Title">

                <div class="input-group-append">
                  <button id="add-new-event" type="button" class="btn btn-primary">Add</button>
                </div>
                <!-- /btn-group -->
              </div>
              <!-- /input-group -->
            </div>
          </div>
        </div>
      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card card-primary">
          <div class="card-body p-0">
            <!-- THE CALENDAR -->
            <div id="calendar"></div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
@stop

@section('footer')
<div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
{!! config('const.manage.footer') !!}
@stop

@section('css')
<!-- fullCalendar -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />

<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
<!-- fullCalendar 2.2.5 -->

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script> --}}
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

<script>
  $(document).ready(function() {

    var SITEURL = "{{url('/')}}";
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    var calendar = $('#calendar').fullCalendar({
      editable: true,
      events: "calendar",
      displayEventTime: true,
      editable: true,
      eventRender: function(event, element, view) {
        if (event.allDay === 'true') {
          event.allDay = true;
        } else {
          event.allDay = false;
        }
      },
      selectable: true,
      selectHelper: true,
      select: function(start, end, allDay) {
        var title = prompt('Event Title:');

        if (title) {
          var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
          var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");

          $.ajax({
            url: "/calendar/create",
            data: 'title=' + title + '&amp;start=' + start + '&amp;end=' + end,
            type: "POST",
            success: function(data) {
              displayMessage("Added Successfully");
            }
          });
          calendar.fullCalendar('renderEvent', {
              title: title,
              start: start,
              end: end,
              allDay: allDay
            },
            true
          );
        }
        calendar.fullCalendar('unselect');
      },

      eventDrop: function(event, delta) {
        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
        $.ajax({
          url: '/calendar/update',
          data: 'title=' + event.title + '&amp;start=' + start + '&amp;end=' + end + '&amp;id=' + event.id,
          type: "POST",
          success: function(response) {
            displayMessage("Updated Successfully");
          }
        });
      },
      eventClick: function(event) {
        var deleteMsg = confirm("Do you really want to delete?");
        if (deleteMsg) {
          $.ajax({
            type: "POST",
            url: '/calendar/delete',
            data: "&amp;id=" + event.id,
            success: function(response) {
              if (parseInt(response) > 0) {
                $('#calendar').fullCalendar('removeEvents', event.id);
                displayMessage("Deleted Successfully");
              }
            }
          });
        }
      }

    });
  });

  function displayMessage(message) {
    $(".response").html("<div class='success'>" + message + "</div>");
    setInterval(function() {
      $(".success").fadeOut();
    }, 1000);
  }
</script>
@stop
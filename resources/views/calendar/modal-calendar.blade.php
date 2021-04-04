<div class="modal fade" id="modalCalendar" tabindex="-1" role="dialog" aria-labelledby="titleModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titleModal">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="message"></div>
        <form id="formEvent">
          <div class="form-group row">
            <label for="title" class="col-sm-4 col-form-label">@lang('common.title')</label>
            <div class="col-sm-8">
              <input type="text" name="title" class="form-control" id="title">
              <input type="hidden" name="id">
              <input type="hidden" name="sid" value="{{$sid}}">
            </div>
          </div>
          <div class="form-group row">
            <label for="start" class="col-sm-4 col-form-label">@lang('calendar.start_date')</label>
            <div class="col-sm-8">
              <input type="text" name="start" class="form-control data-time" id="start">
            </div>
          </div>
          <div class="form-group row">
            <label for="end" class="col-sm-4 col-form-label">@lang('calendar.end_date')</label>
            <div class="col-sm-8">
              <input type="text" name="end" class="form-control data-time" id="end">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-4 col-form-label">@lang('calendar.event_color')</label>
            <div class="col-sm-8">
              <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                <ul class="fc-color-picker" id="color-chooser">
                  <li><input type="radio" name="color" value="#007bff" id="color-primary"><label for="color-primary"><a class="text-primary"><i class="fas fa-square"></i></a></label></li>
                  <li><input type="radio" name="color" value="#ffc107" id="color-warning"><label for="color-warning"><a class="text-warning"><i class="fas fa-square"></i></a></label></li>
                  <li><input type="radio" name="color" value="#28a745" id="color-success"><label for="color-success"><a class="text-success"><i class="fas fa-square"></i></a></label></li>
                  <li><input type="radio" name="color" value="#dc3545" id="color-danger"><label for="color-danger"><a class="text-danger"><i class="fas fa-square"></i></a></label></li>
                  <li><input type="radio" name="color" value="#6c757d" id="color-muted"><label for="color-muted"><a class="text-muted"><i class="fas fa-square"></i></a></label></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label for="description" class="col-sm-4 col-form-label">@lang('calendar.description')</label>
            <div class="col-sm-8">
              <textarea class="form-control" name="description" id="description" rows="4"></textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('common.close')</button>
        <button type="button" class="btn btn-danger deleteEvent">@lang('common.delete')</button>
        <button type="button" class="btn btn-primary saveEvent">@lang('common.save')</button>
      </div>
    </div>
  </div>
</div>

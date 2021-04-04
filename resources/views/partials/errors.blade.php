@if(count($errors) > 0)
<div class="card-body">
  <div class="alert alert-danger alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h5><i class="icon fas fa-ban"></i> @lang('validation.register_error_title')</h5>
  @lang('validation.error')
  </div>
</div>
@endif

@if (session('warning'))
<div class="card-body">
  <div class="alert alert-warning alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h5><i class="icon fas fa-exclamation-triangle"></i> Warning!</h5>
  {{ session('warning') }}
  </div>
</div>
@endif

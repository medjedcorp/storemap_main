@if (session('danger'))
<div class="card-body">
  <div class="alert alert-danger alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
  {{ session('danger') }}
  </div>
</div>
@endif

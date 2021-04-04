@extends('adminlte::result-page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-12">

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                        </h3>
                    </div>

                    <div class="card-body">
                        <p>Welcome to this beautiful admin panel.</p>
                    </div>
                    <div class="card-footer">

                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
    </div><!-- /.container-fluid -->
</section>

@stop

@section('result-right-sidebar')
test
@stop

@section('footer')
<div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
{!! config('const.manage.footer') !!}
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    console.log('Hi!'); 
</script>
@stop
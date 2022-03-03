@extends('adminlte::page')

@section('title', 'トピックスの編集 - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-12">
      <h1 class="m-0">トピックスの編集</h1>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div>
@stop

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                  <div class="card-body">
                    <form method="POST" action="{{ route('topics.update', $topic->id ) }}">
                      @csrf
                      @method('PUT')
                      <fieldset class="mb-4">
                          <div class="form-group">
                              <label for="title">
                                  タイトル
                              </label>
                              <input id="title" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" value="{{ old('title', isset($topic->title) ? $topic->title : '') }}">
                              @if ($errors->has('title'))
                                  <div class="invalid-feedback">
                                      {{ $errors->first('title') }}
                                  </div>
                              @endif
                          </div>

                          <div class="form-group">
                            <label for="info">項目</label>
                            <select class="form-control" id="info" name="info">
                              @foreach($headers as $header => $val)
                                @if($header == $topic->info)
                                    <option value="{{$header}}" selected>{{$val}}</option>
                                @else
                                    <option value="{{$header}}">{{$val}}</option>
                                @endif
                              @endforeach
                            </select>
                          </div>

                          <div class="form-group">
                              <label for="content">
                                  本文
                              </label>
                              <textarea id="content" name="content" class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" rows="4">{{ old('content', isset($topic->content) ? $topic->content : '') }}</textarea>
                              @if ($errors->has('content'))
                                  <div class="invalid-feedback small text-danger">
                                      {{ $errors->first('content') }}
                                  </div>
                              @endif
                          </div>
      
                          <div class="mt-5">
                              <a class="btn btn-secondary" href="{{ route('home') }}">
                                  キャンセル
                              </a>
      
                              <button type="submit" class="btn btn-primary">
                                  更新する
                              </button>
                          </div>
                      </fieldset>
                  </form>
                  </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
              </div>


        </div>
    </div>
</section>
@stop

@section('footer')
<div class="footer-area">
    <div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
    {!! config('const.manage.footer') !!}
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    console.log('Hi!');
</script>
@stop
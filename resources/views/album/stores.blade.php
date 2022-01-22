@extends('adminlte::page')

@section('title', '店舗画像一覧 - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">{{$c_name}} / @lang('album.store.title')</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item active">@lang('album.store.title')</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
</div>
@stop

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-12">
        <!-- Horizontal Form -->
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-images"></i> @lang('album.store.card_title')
            </h3>
            <div class="card-tools">
              <form id="itemAlbumSearch" action="/album/stores" class="" method="GET">
                @csrf
                @method('get')
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input form="itemAlbumSearch" type="text" name="keyword" class="form-control float-right" placeholder="Search" value="{{$keyword}}">
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                      <i class="fas fa-search"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- /.card-header -->

          <div class="card-body">
            @include('partials.danger')


            <div class="row">
              @can('isAdmin')
              <div class="col-12 text-right mb-2">Adminはcompany_idでのみ検索ができます</div>
              @endcan
              <div class="col-sm-4">
                <h1 class="h3 mt-2 mb-2">@lang('album.store.title')</h1>
                <p class="btn btn-default btn-xs">@lang('album.total_size'):
                  <strong>{{ $total_gbytes }}</strong> / @lang('album.total_img'):<strong>{{ $count }}枚</strong>
                </p>
              </div>
              <div class="col-sm-8 text-right">
                <button type="button" class="btn btn-success btn-lg" onclick="$('#modalImg').modal('show')" data-toggle="modal" data-target="#exampleModalCenter">
                  <i class="fas fa-cloud-upload-alt"></i>&nbsp;@lang('album.upload')
                </button>
              </div>
            </div>
            <table id="imgIndexTable" class="table table-borderless table-sm table-striped-2span">
              <thead>
                <tr>
                  <th>@lang('album.image')</th>
                  <th>@sortablelink('filename', trans('album.filename'))</th>
                  <th>@sortablelink('size', trans('album.volume'))</th>
                  <th>@lang('album.size')</th>
                  <th>@sortablelink('updated_at', trans('album.update'))</th>
                  @can('isSeller')
                  <th class="text-center" style="width:180px;">
                    <form method="POST" action="{{ route('album.store.destroy') }}" class="h-adr" id="img_id">
                      @method('DELETE')
                      @csrf
                      <button type="submit" class="btn btn-sm btn-danger" onclick="delete_alert(event);return false;">
                        チェックを削除 &nbsp;<i class="fa fa-trash"></i></button>
                    </form>
                  </th>
                  @endcan
                </tr>
              </thead>
              <tbody>
                @if(count($images) > 0)
                @foreach($images as $img)
                <tr>
                  <td rowspan="2" class="albumBox"><a href="/storage/{{ $path_as }}{{ $img->filename }}" target="_blank"><img src="/storage/{{ $path_as }}/{{ $img->filename }}" class="albumImg"></a></td>
                  <td>{{ $img->filename }}</td>
                  @php
                  $kbyte = number_format($img->size / 1024, 2) . ' KB';
                  @endphp
                  <td>{{ $kbyte }}</td>
                  <td>{{ $img->width }}×{{ $img->height }} </td>
                  <td>{{ $img->updated_at }}</td>
                  @can('isSeller')
                  <td rowspan="2" class="text-center align-middle">
                    <div class="form-group">
                      <div class="icheck-danger d-inline">
                        <input type="checkbox" id="{{ $img->id }}" name="img_id[]" value="{{ $img->id }}" form="img_id">
                        <label for="{{ $img->id }}"><i class="fa fa-trash"></i>
                        </label>
                      </div>
                    </div>
                  </td>
                  @endcan
                </tr>
                <tr>
                  <td>URL:</td>
                  <td colspan="3">/storage/{{ $path_as }}{{ $img->filename }}</td>
                </tr>
                @endforeach
                @endif
              </tbody>
            </table>
            {{ $images->appends(request()->input())->links() }}
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- Modal -->
<div class="modal fade" id="modalImg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-cloud-upload-alt"></i> @lang('item.upload')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div>
          <div class="form-group {{ $errors->has('file') ? ' has-error' : '' }}">
            <div>
              <form method="POST" action="/img/store/upload" class="dropzone" id="imageUpload" enctype="multipart/form-data">
                @csrf
                @method('POST')
                @can('isAdmin')
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">company_id @include('partials.required') </label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="company_id" name="company_id" placeholder="company_idを入力">
                    <small class="text-red">※Adminのみの項目。基本触らない</small>
                  </div>
                </div>
                @endcan
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
@stop

@section('footer')
<div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
{!! config('const.manage.footer') !!}
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/dropzone.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/icheck-bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
<script src="{{ asset('js/dropzone.min.js') }}" rel="stylesheet"></script>
<script src="{{ asset('js/delete_alert.js') }}"></script>

<script type="text/javascript">
  Dropzone.options.imageUpload = {
    dictDefaultMessage: 'アップロードするファイルをここへドロップしてください。<br>縦横の最大幅は750pxです。大きさを超える場合は、自動でリサイズされます。<br>同じファイル名の画像がある場合は上書きされます。<br>アップロードした画像は画像管理の店舗画像より確認できます。<br>日本語や全角文字を含むファイル名は、自動で半角ファイル名へリネームされます。<br>１度にアップできる枚数は５００枚までです。',
    dictInvalidFileType: "jpg、gif、pngファイルのみアップロード可能です。",
    paramName: 'images',
    resizeWidth: 750,
    resizeHeight: 750,
    resizeQuality: .9,
    timeout: 10000,
    /*milliseconds*/
    maxFiles: 500, // アップできる枚数
    acceptedFiles: '.jpg, .jpeg, .gif, .png',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    @can('isAdmin')
    init: function() {
      this.on("sending", function(file, xhr, formData) {
        var id = document.getElementById('company_id');
        formData.append("company_id", id);
        //formData.append('task_name', jQuery('#task_name').val());
      });
    },
    @endcan
    success: function(file, response) {
      // var $message = response.errors.file;
      file.previewElement.classList.add("dz-success");
      $(file.previewElement).find('.dz-success-mark').show();
      $(file.previewElement).find('[data-dz-name]').text(response.success);
      // console.log(response.success);
    },
    error: function(file, response) {
      file.previewElement.classList.add('dz-error');
      $(file.previewElement).find('.dz-error-message').text(response);
      alert("容量オーバーです。画像の登録に失敗しました。");
      location.reload();
      response.preventDefault();
    },
    maxfilesreached: function(file, response) {
      // maxFilesをオーバーした場合、アラートを表示
      alert("※Error：１度にアップできる画像は５００枚までです。登録可能な範囲で登録します。");
      // 処理を中断。これがないとオーバーした分のエラーポップアップが表示されます。
      response.preventDefault();
    },
    queuecomplete: function(file, response) {
      // アップロード完了時の処理。アラートを表示
      alert("アップロードが完了しました");
      // OKすると画面リロード
      location.reload();
    },
  };
</script>

@stop
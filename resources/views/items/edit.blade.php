@extends('adminlte::page')

@section('title', '商品情報の編集 - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-7">
      <h1 class="m-0"><span class="h4"><i class="fas fa-edit"></i> {{$item->product_name}}/<span class="h5">{{$item->product_code}} の
      @lang('item.edit.title')</span></span></h1>
    </div><!-- /.col -->
    <div class="col-sm-5">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item"><a href="/items">商品一覧</a></li>
        <li class="breadcrumb-item active">@lang('item.main.base')</li>
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
        <div class="card card-primary card-tabs">
          <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
              <li class="pt-2 px-3">
                <h3 class="card-title"><i class="far fa-list-alt"></i> @lang('item.edit.card_title')</h3>
              </li>
              <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-two-base-tab" data-toggle="pill" href="" role="tab" aria-controls="custom-tabs-two-base" aria-selected="false">@lang('item.main.base')</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-two-store-tab" data-toggle="pill" role="tab" aria-controls="custom-tabs-two-store" onclick="location.href='{{ route('items.seller.edit' , $item->id ) }}'" aria-selected="false">@lang('item.main.store')</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-two-price-tab" data-toggle="pill" href="price" role="tab" aria-controls="custom-tabs-two-price" aria-selected="false" onclick="location.href='{{ route('items.price.edit' , $item->id ) }}'">@lang('item.main.price')</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-two-stock-tab" data-toggle="pill" href="stock" role="tab" aria-controls="custom-tabs-two-stock" aria-selected="true" onclick="location.href='{{ route('items.stock.edit' , $item->id ) }}'">@lang('item.main.stock')</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-two-comment-tab" data-toggle="pill" href="comment" role="tab" aria-controls="custom-tabs-two-comment" aria-selected="true" onclick="location.href='{{ route('items.comment.edit' , $item->id ) }}'">@lang('item.main.comment')</a>
              </li>
            </ul>
          </div>

          @include('partials.errors')
          @include('partials.success')

          <div class="card-body">

            <div class="form-group row">
              <label for="product_code" class="col-sm-2 col-form-label">@lang('item.product_code')
                @include('partials.required')</label>
              <div class="col-sm-10">
                @if($errors->has('product_code'))
                <input form="item_form" type="text" class="form-control is-invalid" name="product_code" id="product_code" placeholder="@lang('item.product_code_pholder')" value="{{ old('product_code', $item->product_code) }}" aria-describedby="product_code-error" aria-invalid="true">
                <span id="product_code-error" class="error invalid-feedback">{{$errors->first('product_code')}}</span>
                @else
                <input form="item_form" type="text" class="form-control" id="product_code" name="product_code" placeholder="@lang('item.product_code_pholder')" value="{{ old('product_code', isset($item->product_code) ? $item->product_code : '') }}">
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="product_name" class="col-sm-2 col-form-label">@lang('item.product_name')
                @include('partials.required')</label>
              <div class="col-sm-10">
                @if($errors->has('product_name'))
                <input form="item_form" type="text" class="form-control is-invalid" name="product_name" id="product_name" placeholder="@lang('item.product_name_pholder')" value="{{ old('product_name', $item->product_name) }}" aria-describedby="product_name-error" aria-invalid="true">
                <span id="product_name-error" class="error invalid-feedback">{{$errors->first('product_name')}}</span>
                @else
                <input form="item_form" type="text" class="form-control" id="product_name" name="product_name" placeholder="@lang('item.product_name_pholder')" value="{{ old('product_name', isset($item->product_name) ? $item->product_name : '') }}">
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="barcode" class="col-sm-2 col-form-label">@lang('common.barcode')</label>
              <div class="col-sm-10">
                @if($errors->has('barcode'))
                <input form="item_form" type="text" class="form-control is-invalid" name="barcode" id="barcode" placeholder="@lang('item.barcode_pholder')" value="{{ old('barcode', $item->barcode) }}" aria-describedby="barcode-error" aria-invalid="true">
                <span id="barcode-error" class="error invalid-feedback">{{$errors->first('barcode')}}</span>
                @else
                <input form="item_form" type="text" class="form-control" id="barcode" name="barcode" placeholder="@lang('item.barcode_pholder')" value="{{ old('barcode', isset($item->barcode) ? $item->barcode : '') }}">
                @endif
              </div>
            </div>
            @if( $company->maker_flag == 1 )
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">@lang('common.catalog') <i type="button" class="fas fa-question-circle text-warning" data-toggle="tooltip" data-placement="right" title="" data-original-title="登録することで商品情報を小売店が参照可能になり販路拡大に繋がります"></i> @include('partials.required') </label>
              <div class="col-sm-10">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-outline-info">
                    <input form="item_form" type="radio" name="global_flag" id="global_flag1" value="1" {{ old( 'global_flag' , $item->global_flag ) == '1' ? 'checked' : '' }}>@lang('item.yes')
                  </label>
                  <label class="btn btn-outline-info">
                    <input form="item_form" type="radio" name="global_flag" id="global_flag0" value="0" {{ old( 'global_flag' , $item->global_flag ) == '0' ? 'checked' : '' }}>@lang('item.no')
                  </label>
                </div>
                @if($errors->has('global_flag'))
                <div class="small text-danger">{{$errors->first('global_flag')}}</div>
                @endif
              </div>
            </div>
            @else
            <input form="item_form" type="hidden" name="global_flag" value="0">
            @endif
            <div class="form-group row">
              <label for="brand_name" class="col-sm-2 col-form-label">@lang('item.brand_name')</label>
              <div class="col-sm-10">
                @if($errors->has('brand_name'))
                <input form="item_form" type="text" class="form-control is-invalid" name="brand_name" id="brand_name" placeholder="@lang('item.brand_name_pholder')" value="{{ old('brand_name', $item->brand_name) }}" aria-describedby="brand_name-error" aria-invalid="true">
                <span id="brand_name-error" class="error invalid-feedback">{{$errors->first('brand_name')}}</span>
                @else
                <input form="item_form" type="text" class="form-control" id="brand_name" name="brand_name" placeholder="@lang('item.brand_name_pholder')" value="{{ old('brand_name', isset($item->brand_name) ? $item->brand_name : '') }}">
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="color_id" class="col-sm-2 col-form-label">
                @lang('item.color')
              </label>
              <div class="col-sm-10">
                <select form="item_form" name="color_id" class="form-control" id="select_colors">
                  <option value="">カラー系統があれば選択してください</option>
                  @if( old('color_id'))
                    @foreach($colors as $color)
                      @if( old('color_id') == $color->id )
                      <option value="{{$color->id}}" data-icon="/img/color-{{$loop->iteration}}.gif" selected>{{ $color->color_list }}</option>
                      @else
                      <option value="{{$color->id}}" data-icon="/img/color-{{$loop->iteration}}.gif">{{ $color->color_list }}</option>
                      @endif
                    @endforeach
                  @elseif(isset($item->color_id) == true)
                    @foreach($colors as $color)
                      @if( $item->color_id == $color->id )
                      <option value="{{$color->id}}" data-icon="/img/color-{{$loop->iteration}}.gif" selected>{{ $color->color_list }}</option>
                      @else
                      <option value="{{$color->id}}" data-icon="/img/color-{{$loop->iteration}}.gif">{{ $color->color_list }}</option>
                      @endif
                    @endforeach
                  @else
                    @foreach($colors as $color)
                      <option value="{{$color->id}}" data-icon="/img/color-{{$loop->iteration}}.gif">{{ $color->color_list }}</option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label for="color_name" class="col-sm-2 col-form-label">@lang('item.color_name')</label>
              <div class="col-sm-10">
                @if($errors->has('color_name'))
                <input form="item_form" type="text" class="form-control is-invalid" name="color_name" id="color_name" placeholder="@lang('item.color_name_pholder')" value="{{ old('color_name', $item->color_name) }}" aria-describedby="color_name-error" aria-invalid="true">
                <span id="color_name-error" class="error invalid-feedback">{{$errors->first('color_name')}}</span>
                @else
                <input form="item_form" type="text" class="form-control" id="color_name" name="color_name" placeholder="@lang('item.color_name_pholder')" value="{{ old('color_name', isset($item->color_name) ? $item->color_name : '') }}">
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="size_name" class="col-sm-2 col-form-label">@lang('item.size_name')</label>
              <div class="col-sm-10">
                @if($errors->has('size_name'))
                <input form="item_form" type="text" class="form-control is-invalid" name="size_name" id="size_name" placeholder="@lang('item.size_name_pholder')" value="{{ old('size_name', $item->size_name) }}" aria-describedby="size_name-error" aria-invalid="true">
                <span id="size_name-error" class="error invalid-feedback">{{$errors->first('size_name')}}</span>
                @else
                <input form="item_form" type="text" class="form-control" id="size_name" name="size_name" placeholder="@lang('item.size_name_pholder')" value="{{ old('size_name', isset($item->size_name) ? $item->size_name : '') }}">
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">@lang('item.display_flag') @include('partials.required')</label>
              <div class="col-sm-10">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-outline-info">
                    <input form="item_form" type="radio" name="display_flag" id="display_flag1" value="1" {{ old( 'display_flag' , $item->display_flag ) == '1' ? 'checked' : '' }}>@lang('item.show')
                  </label>
                  <label class="btn btn-outline-info">
                    <input form="item_form" type="radio" name="display_flag" id="display_flag0" value="0" {{ old( 'display_flag' , $item->display_flag ) == '0' ? 'checked' : '' }}>@lang('item.hide')
                  </label>
                </div>
                @if($errors->has('display_flag'))
                <div class="small text-danger">{{$errors->first('display_flag')}}</div>
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">@lang('item.item_status') @include('partials.required')</label>
              <div class="col-sm-10">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-outline-info">
                    <input form="item_form" type="radio" name="item_status" id="item_status1" value="1" {{ old( 'item_status' , $item->item_status ) == '1' ? 'checked' : '' }}>@lang('common.new')
                  </label>
                  <label class="btn btn-outline-info">
                    <input form="item_form" type="radio" name="item_status" id="item_status0" value="0" {{ old( 'item_status' , $item->item_status ) == '0' ? 'checked' : '' }}>@lang('common.used')
                  </label>
                </div>
                @if($errors->has('item_status'))
                <div class="small text-danger">{{$errors->first('item_status')}}</div>
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="original_price" class="col-sm-2 col-form-label">@lang('common.original_price')</label>
              <div class="col-sm-10">
                @if($errors->has('original_price'))
                <input form="item_form" type="number" class="form-control is-invalid" name="original_price" id="original_price" value="{{ old('original_price', $item->original_price) }}" aria-describedby="original_price-error" aria-invalid="true">
                <span id="original_price-error" class="error invalid-feedback">{{$errors->first('original_price')}}</span>
                @else
                <input form="item_form" type="number" class="form-control" id="original_price" name="original_price" value="{{ old('original_price', $item->original_price) }}">
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="description" class="col-sm-2 col-form-label">@lang('item.description')</label>
              <div class="col-sm-10">
                @if($errors->has('description'))
                <textarea form="item_form" type="textarea" class="form-control is-invalid" name="description" id="description" placeholder="@lang('item.description_pholder')" aria-describedby="description-error" aria-invalid="true" rows="3">{{ old('description', $item->description) }}</textarea>
                <span id="description-error" class="error invalid-feedback">{{$errors->first('description')}}</span>
                @else
                <textarea form="item_form" type="textarea" class="form-control" id="description" name="description" placeholder="@lang('item.description_pholder')" rows="3">{{ old('description', $item->description) }}</textarea>
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="size" class="col-sm-2 col-form-label">@lang('item.size')</label>
              <div class="col-sm-10">
                @if($errors->has('size'))
                <textarea form="item_form" type="textarea" class="form-control is-invalid" name="size" id="size" placeholder="@lang('item.size_pholder')" aria-describedby="size-error" aria-invalid="true" rows="3">{{ old('size', $item->size) }}</textarea>
                <span id="size-error" class="error invalid-feedback">{{$errors->first('size')}}</span>
                @else
                <textarea form="item_form" type="textarea" class="form-control" id="size" name="size" placeholder="@lang('item.size_pholder')" rows="3">{{ old('size', $item->size) }}</textarea>
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="tag" class="col-sm-2 col-form-label">@lang('item.tag')</label>
              <div class="col-sm-10">
                @if($errors->has('tag'))
                <input form="item_form" type="text" class="form-control is-invalid" name="tag" id="tag" placeholder="@lang('item.tag_pholder')" value="{{ old('tag', $item->tag) }}" aria-describedby="tag-error" aria-invalid="true">
                <span id="tag-error" class="error invalid-feedback">{{$errors->first('tag')}}</span>
                @else
                <input form="item_form" type="text" class="form-control" id="tag" name="tag" placeholder="@lang('item.tag_pholder')" value="{{ old('tag', $item->tag) }}">
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="group_code" class="col-sm-2 col-form-label">@lang('item.group_code')</label>
              <div class="col-sm-10">
                @if($errors->has('group_code'))
                <input form="item_form" type="text" class="form-control is-invalid" name="group_code" id="group_code" placeholder="@lang('item.group_code_pholder')" value="{{ old('group_code', $item->group_code->group_code) }}" aria-describedby="group_code-error" aria-invalid="true">
                <span id="group_code-error" class="error invalid-feedback">{{$errors->first('group_code')}}</span>
                @else
                <input form="item_form" type="text" class="form-control" id="group_code" name="group_code" placeholder="@lang('item.group_code_pholder')" value="{{ old('group_code', isset($item->group_code_id) ? $item->group_code->group_code : '')  }}">
                @endif

              </div>
            </div>
            <div id="smcate" class="form-group row">
              <label for="first_layer" class="col-sm-2 col-form-label">@lang('item.sm_cate')<br><small>@lang('item.or_sm_cate')</small></label>
              <div class="col-sm-10">
                <small>キーワードから選ぶ</small>
                <div class="form-group row">
                  <div class="col-4 input-group">
                    <input form="item_form" type="text" name="sm_search" id="sm_search" class="form-control" placeholder="キーワードから検索">
                    <div class="input-group-append">
                      <span class="input-group-text" type="button"><i class="fa fa-search"></i></span>
                    </div>
                  </div>
                  <div class="col-8">
                    <select form="item_form" name="storemap_category_id[]" id="sm_search_result" class="form-control">
                      <option value="{{ old('storemap_category_id[]', isset($item->storemap_category_id) ? $item->storemap_category_id : '') }}">
                        {{ old('storemap_category_id[]', isset($smcate) ? $smcate : '選択してください') }}</option>
                    </select>
                  </div>
                </div>
                <small>選択肢から選ぶ</small>
                <div class="form-group row">
                  <div class="col-2 pr-0">
                    <select form="item_form" name="storemap_category_id[]" id="smLayer1" class="form-control">
                      <option value="" hidden>選択してください</option>
                      @foreach($first_layer as $id => $first)
                      <option value="{{ $first->id }}">
                        {{ $first->smcategory_name }}
                      </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-2 pl-0 pr-0">
                    <select form="item_form" name="storemap_category_id[]" id="smLayer2" class="form-control">
                      <option value=""></option>
                    </select>
                  </div>
                  <div class="col-2 pr-0 pl-0">
                    <select form="item_form" name="storemap_category_id[]" id="smLayer3" class="form-control" style="display:none;">
                      <option value=""></option>
                    </select>
                  </div>
                  <div class="col-2 pr-0 pl-0">
                    <select form="item_form" name="storemap_category_id[]" id="smLayer4" class="form-control" style="display:none;">
                      <option value=""></option>
                    </select>
                  </div>
                  <div class="col-2 pr-0 pl-0">
                    <select form="item_form" name="storemap_category_id[]" id="smLayer5" class="form-control" style="display:none;">
                      <option value=""></option>
                    </select>
                  </div>
                  <div class="col-2 pl-0">
                    <select form="item_form" name="storemap_category_id[]" id="smLayer6" class="form-control" style="display:none;">
                      <option value=""></option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">@lang('item.category')</label>
              <div class="col-sm-10">
                <select form="item_form" name="category_id" class="form-control">
                  @if(isset($category) == true)
                  <option value=""></option>
                  @foreach($category as $value)
                  @if($item->category_id == $value->id)
                  <option value="{{$value->id}}" selected>{{$value->category_name}}</option>
                  @else
                  <option value="{{$value->id}}">{{$value->category_name}}</option>
                  @endif
                  @endforeach
                  @else
                  <option value=""></option>
                  @endif
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">@lang('item.photo')</label>
              <div class="col-sm-10">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#imgModal">
                  <i class="fas fa-cloud-upload-alt"></i> @lang('item.upload')
                </button>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">@lang('item.img')</label>
              <div class="col-sm-10">
                <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="item_img1" class="col-form-label">@lang('item.img01')</label>
                    <div @error('item_img1') class="select2-has-error" @enderror>
                      <select form="item_form" class="form-control select2 img01-ajax is-invalid" id="item_img1" name="item_img1" style="width: 100%;">
                        <option value="{{ old('item_img1', $item->item_img1) }}">{{ old('item_img1',$item->item_img1) }}
                        </option>
                      </select>
                      @if($errors->has('item_img1'))
                      <span id="item_img1-error" class="error invalid-feedback">{{$errors->first('item_img1')}}</span>
                      @endif
                    </div>
                  </div>

                  <div class="form-group col-sm-6">
                    <label for="item_img2" class="col-form-label">@lang('item.img02')</label>
                    <div @error('item_img2') class="select2-has-error" @enderror>
                      <select form="item_form" class="form-control select2 img02-ajax is-invalid" id="item_img2" name="item_img2" style="width: 100%;">
                        <option value="{{ old('item_img2',$item->item_img2) }}">{{ old('item_img2',$item->item_img2) }}
                        </option>
                      </select>
                      @if($errors->has('item_img2'))
                      <span id="item_img2-error" class="error invalid-feedback">{{$errors->first('item_img2')}}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="item_img3" class="col-form-label">@lang('item.img03')</label>
                    <div @error('item_img3') class="select2-has-error" @enderror>
                      <select form="item_form" class="form-control select2 img03-ajax is-invalid" id="item_img3" name="item_img3" style="width: 100%;">
                        <option value="{{ old('item_img3',$item->item_img3) }}">{{ old('item_img3',$item->item_img3) }}
                        </option>
                      </select>
                      @if($errors->has('item_img3'))
                      <span id="item_img3-error" class="error invalid-feedback">{{$errors->first('item_img3')}}</span>
                      @endif
                    </div>
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="item_img4" class="col-form-label">@lang('item.img04')</label>
                    <div @error('item_img4') class="select2-has-error" @enderror>
                      <select form="item_form" class="form-control select2 img04-ajax is-invalid" id="item_img4" name="item_img4" style="width: 100%;">
                        <option value="{{ old('item_img4',$item->item_img4) }}">{{ old('item_img4',$item->item_img4) }}
                        </option>
                      </select>
                      @if($errors->has('item_img4'))
                      <span id="item_img4-error" class="error invalid-feedback">{{$errors->first('item_img4')}}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="item_img5" class="col-form-label">@lang('item.img05')</label>
                    <div @error('item_img5') class="select2-has-error" @enderror>
                      <select form="item_form" class="form-control select2 img05-ajax is-invalid" id="item_img5" name="item_img5" style="width: 100%;">
                        <option value="{{ old('item_img5',$item->item_img5) }}">{{ old('item_img5',$item->item_img5) }}
                        </option>
                      </select>
                      @if($errors->has('item_img5'))
                      <span id="item_img5-error" class="error invalid-feedback">{{$errors->first('item_img5')}}</span>
                      @endif
                    </div>
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="item_img6" class="col-form-label">@lang('item.img06')</label>
                    <div @error('item_img6') class="select2-has-error" @enderror>
                      <select form="item_form" class="form-control select2 img06-ajax is-invalid" id="item_img6" name="item_img6" style="width: 100%;">
                        <option value="{{ old('item_img6',$item->item_img6) }}">{{ old('item_img6',$item->item_img6) }}
                        </option>
                      </select>
                      @if($errors->has('item_img6'))
                      <span id="item_img6-error" class="error invalid-feedback">{{$errors->first('item_img6')}}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="item_img7" class="col-form-label">@lang('item.img07')</label>
                    <div @error('item_img7') class="select2-has-error" @enderror>
                      <select form="item_form" class="form-control select2 img07-ajax is-invalid" id="item_img7" name="item_img7" style="width: 100%;">
                        <option value="{{ old('item_img7',$item->item_img7) }}">{{ old('item_img7',$item->item_img7) }}
                        </option>
                      </select>
                      @if($errors->has('item_img7'))
                      <span id="item_img7-error" class="error invalid-feedback">{{$errors->first('item_img7')}}</span>
                      @endif
                    </div>
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="item_img8" class="col-form-label">@lang('item.img08')</label>
                    <div @error('item_img8') class="select2-has-error" @enderror>
                      <select form="item_form" class="form-control select2 img08-ajax is-invalid" id="item_img8" name="item_img8" style="width: 100%;">
                        <option value="{{ old('item_img8',$item->item_img8) }}">{{ old('item_img8',$item->item_img8) }}
                        </option>
                      </select>
                      @if($errors->has('item_img8'))
                      <span id="item_img8-error" class="error invalid-feedback">{{$errors->first('item_img8')}}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="item_img9" class="col-form-label">@lang('item.img09')</label>
                    <div @error('item_img9') class="select2-has-error" @enderror>
                      <select form="item_form" class="form-control select2 img09-ajax is-invalid" id="item_img9" name="item_img9" style="width: 100%;">
                        <option value="{{ old('item_img9',$item->item_img9) }}">{{ old('item_img9',$item->item_img9) }}
                        </option>
                      </select>
                      @if($errors->has('item_img9'))
                      <span id="item_img9-error" class="error invalid-feedback">{{$errors->first('item_img9')}}</span>
                      @endif
                    </div>
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="item_img10" class="col-form-label">@lang('item.img10')</label>
                    <div @error('item_img10') class="select2-has-error" @enderror>
                      <select form="item_form" class="form-control select2 img10-ajax is-invalid" id="item_img10" name="item_img10" style="width: 100%;">
                        <option value="{{ old('item_img10',$item->item_img10) }}">{{ old('item_img10',$item->item_img10) }}
                        </option>
                      </select>
                      @if($errors->has('item_img10'))
                      <span id="item_img10-error" class="error invalid-feedback">{{$errors->first('item_img10')}}</span>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card -->
          <!-- /.card-body -->
          <div class="card-footer">
            <form method="POST" action="{{route('items.update' , $item->id )}}" enctype="multipart/form-data" class="h-adr inline_form" id="item_form">
              @csrf
              @method('PATCH')
              <input form="item_form" type="hidden" name="company_id" value="{{$company->id}}">
              <input form="item_form" type="hidden" name="id" value="{{$item->id}}">
              <button form="item_form" type="submit" class="btn btn-primary"><i class="fa fa-check-square"></i>
                @lang('item.edit.submit')</button>
            </form>
            <button class="btn btn-default float-right" onclick="location.href='{{ route('items.index') }}'"><i class="fa fa-reply"></i> @lang('common.back')</button>
          </div>
          <!-- /.card-footer -->
        </div>

      </div>
      <!-- /.row -->
    </div>
  </div><!-- /.container-fluid -->
</section>
<!-- Modal -->
<div class="modal fade" id="imgModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
              <form method="POST" action="/img/item/upload" class="dropzone" id="imageUpload" enctype="multipart/form-data">
                @csrf
                @method('POST')
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

<!-- loading -->
<div id="overlay">
  <div class="cv-spinner">
    <span class="spinner"></span>
  </div>
</div>
@stop

@section('right-sidebar')
<div class="os-padding text-sm">
  <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
    <div class="os-content" style="padding: 16px; height: 100%; width: 100%;">
      <h5>商品情報の編集</h5>
      <hr class="mb-2">
      <p>商品情報の編集が出来ます。商品情報のタブより、商品ごとの取扱店舗、価格設定、在庫設定、店舗からのコメントが登録・編集可能です。※店舗登録がない場合は、先に店舗の登録が必要です。</p>
      <dl>
        <dt>商品コード</dt>
        <dd>商品コードを入力してください。半角英数とハイフン(-)のみ利用可能です。</dd>
        <dt>商品名</dt>
        <dd>商品名を入力してください。</dd>
        <dt>JANコード</dt>
        <dd>JANコードを入力してください。数字のみ利用可能です。@if( $company->maker_flag == 1 )カタログ出品の設定をする場合は、会社設定で登録したGS1事業者コードから始まる値を入力してください。※カタログ出品の設定をすると御社の商品を取り扱う他社が、この商品情報を参照して簡単に出品できるようになります。@endif</dd>
        <dt>ブランド名</dt>
        <dd>ブランド名を入力してください。</dd>
        <dt>商品カラー</dt>
        <dd>商品に類似する色があれば入力してください。</dd>
        <dt>表示設定</dt>
        <dd>非表示を選択すると、店舗管理で登録した店舗内で全て非表示となります。</dd>
        <dt>定価</dt>
        <dd>商品に定価がある場合は入力してください。空欄の場合はオープン価格となります。店舗個別での価格設定は、商品情報登録後に商品一覧より変更できます。</dd>
        <dt>検索用タグ</dt>
        <dd>検索用のキーワードを入力してください。サイトのトップページで検索されたときに表示されます。※商品と関係のないキーワードを入力しないでください。</dd>
        <dt>グループコード</dt>
        <dd>商品にカラーバリエーションや、サイズ違いなどがある場合は代表となる商品コードを入れるとグループ化することができます。</dd>
        <dt>ストアマップカテゴリ</dt>
        <dd>サイトのトップページから、カテゴリを絞って表示させることができます。キーワードを入力して選択するか、選択肢よりプルダウンで選択してください。※下位カテゴリは自動で表示されます。</dd>
        <dt>カテゴリ設定</dt>
        <dd>[カテゴリ管理]より設定した、会社内での商品カテゴリを登録できます。登録したカテゴリは、サイトの店舗情報で使用されます。</dd>
        <dt>商品画像</dt>
        <dd>アップロードするボタンをクリックすることで、商品画像のアップロードができます。アップロードした画像は、[画像管理＞商品画像管理]より確認できます。</dd>
        <dt>画像ファイル名</dt>
        <dd>商品画像でアップロードした、画像のファイル名を入力してください。商品画像1枚目はサムネイル画像として使用されます。</dd>
      </dl>
    </div>
  </div>
</div>
@stop

@section('footer')
<div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
{!! config('const.manage.footer') !!}
@stop

@section('plugins.Select2', true)

@section('css')
<link rel="stylesheet" href="{{ asset('css/dropzone.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
<link rel="stylesheet" href="{{ asset('css/wSelect.css') }}">
@stop

@section('js')
<script src="{{ asset('js/smcate.js') }}"></script>
<script src="{{ asset('js/wSelect.min.js') }}"></script>
<script type="text/javascript">
  $('#select_colors').wSelect();
</script>
<script>
  $(function() {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>
<script src="{{ asset('js/dropzone.min.js') }}" rel="stylesheet"></script>
<script src="{{ asset('js/itemimg_select.js') }}" rel="stylesheet"></script>

<script type="text/javascript">
  Dropzone.options.imageUpload = {
    dictDefaultMessage: 'アップロードするファイルをここへドロップしてください。<br>縦横の最大幅は750pxです。大きさを超える場合は、自動でリサイズされます。<br>同じファイル名の画像がある場合は上書きされます。<br>アップロードした画像は画像管理の店舗画像より確認できます。<br>日本語や全角文字を含むファイル名は、自動で半角ファイル名へリネームされます。',
    dictInvalidFileType: "jpgとgifとpngファイルのみアップロード可能です。",
    paramName: 'images',
    resizeWidth: 750,
    resizeHeight: 750,
    resizeQuality: 1,
    acceptedFiles: '.jpg, .jpeg, .gif, .png',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(file, response) {
      // var $message = response.errors.file;
      file.previewElement.classList.add("dz-success");
      $(file.previewElement).find('.dz-success-mark').show();
      $(file.previewElement).find('[data-dz-name]').text(response.success);

      console.log(response.success);
    },
    error: function(file, response) {
      file.previewElement.classList.add('dz-error');
      $(file.previewElement).find('.dz-error-message').text(response);
    },
  };
</script>
<script type="text/javascript">
  $('#imgModal').on('shown.bs.modal', function() {
    $('#myInput').trigger('focus')
  })
</script>
@stop
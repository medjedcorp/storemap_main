@extends('adminlte::page')

@section('title', '店舗の編集 - Storemap Cockpit')

@section('content_header')
<h1>{{$c_name}} / @lang('store.edit.title')</h1>
@stop

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-12">
        <!-- Horizontal Form -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-store"></i> {{$store->store_name}} の @lang('store.edit.card_title')</h3>
          </div>
          <!-- /.card-header -->
          @include('partials.errors')
          <!-- form start -->
          <div class="card-body h-adr">
            <div class="form-group row">
              <span class="p-country-name" style="display:none;">Japan</span>
              <label for="store_code" class="col-sm-2 col-form-label">
                @lang('store.register.store_code')
                @include('partials.required')
              </label>
              <div class="col-sm-10">
                @if($errors->has('store_code'))
                <input form="store_form" type="text" class="form-control is-invalid" name="store_code" id="store_code" placeholder="@lang('store.register.store_code_pholder')" value="{{ old('store_code') }}" aria-describedby="store_code-error" aria-invalid="true">
                <span id="store_code-error" class="error invalid-feedback">{{$errors->first('store_code')}}</span>
                @else
                <input form="store_form" type="text" class="form-control" id="store_code" name="store_code" placeholder="@lang('store.register.store_code_pholder')" value="{{ old('store_code', $store->store_code) }}">
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="store_name" class="col-sm-2 col-form-label">@lang('store.register.store_name') @include('partials.required')</label>
              <div class="col-sm-10">
                @if($errors->has('store_name'))
                <input form="store_form" type="text" class="form-control is-invalid" name="store_name" id="store_name" placeholder="@lang('store.register.store_name_pholder')" value="{{old('store_name')}}" aria-describedby="store_name-error" aria-invalid="true">
                <span id="store_name-error" class="error invalid-feedback">{{$errors->first('store_name')}}</span>
                @else
                <input form="store_form" type="text" class="form-control" id="store_name" name="store_name" placeholder="@lang('store.register.store_name_pholder')" value="{{ old('store_name', $store->store_name) }}">
                @endif
              </div>
            </div>
            @if (App::isLocale('ja')) {{-- 日本語のときだけ表示 --}}
            <div class="form-group row">
              <label for="store_kana" class="col-sm-2 col-form-label">店舗名かな</label>
              <div class="col-sm-10">
                @if($errors->has('store_kana'))
                <input form="store_form" type="text" class="form-control is-invalid" name="store_kana" id="store_kana" placeholder="店舗名をひらがなで入力してください" value="{{old('store_kana')}}" aria-describedby="store_kana-error" aria-invalid="true">
                <span id="store_kana-error" class="error invalid-feedback">{{$errors->first('store_kana')}}</span>
                @else
                <input form="store_form" type="text" class="form-control" id="store_kana" name="store_kana" placeholder="店舗名をひらがなで入力してください" value="{{ old('store_kana', $store->store_kana) }}">
                @endif
              </div>
            </div>
            @endif
            <div class="form-group row">
              <label for="store_postcode" class="col-sm-2 col-form-label">
                @lang('common.postcode')
                @include('partials.required')
              </label>
              <div class="col-sm-10">
                @if($errors->has('store_postcode'))
                <input form="store_form" type="text" class="form-control is-invalid p-postal-code" name="store_postcode" id="store_postcode" value="{{old('store_postcode')}}" aria-describedby="store_postcode-error" aria-invalid="true" placeholder="@lang('common.pcode_pholder')">
                <span id="store_postcode-error" class="error invalid-feedback">{{$errors->first('store_postcode')}}</span>
                @else
                <input form="store_form" type="text" class="form-control p-postal-code" id="store_postcode" name="store_postcode" value="{{ old('store_postcode', $store->store_postcode) }}" placeholder="@lang('common.pcode_pholder')">
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="prefecture" class="col-sm-2 col-form-label">@lang('common.prefecture') @include('partials.required')</label>
              <div class="col-sm-10">
                @if($errors->has('prefecture'))
                <input form="store_form" type="text" class="form-control is-invalid p-region" name="prefecture" id="prefecture" value="{{old('prefecture')}}" aria-describedby="prefecture-error" aria-invalid="true">
                <span id="prefecture-error" class="error invalid-feedback">{{$errors->first('prefecture')}}</span>
                @else
                <input form="store_form" type="text" class="form-control p-region" id="prefecture" name="prefecture" value="{{ old('prefecture', $store->prefecture) }}">
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="store_city" class="col-sm-2 col-form-label">@lang('common.city') @include('partials.required')</label>
              <div class="col-sm-10">
                @if($errors->has('store_city'))
                <input form="store_form" type="text" class="form-control is-invalid p-locality" name="store_city" id="store_city" value="{{old('store_city')}}" aria-describedby="store_city-error" aria-invalid="true">
                <span id="store_city-error" class="error invalid-feedback">{{$errors->first('store_city')}}</span>
                @else
                <input form="store_form" type="text" class="form-control p-locality" id="store_city" name="store_city" value="{{ old('store_city', $store->store_city) }}">
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="store_adnum" class="col-sm-2 col-form-label">@lang('common.adnum') @include('partials.required')</label>
              <div class="col-sm-10">
                @if($errors->has('store_adnum'))
                <input form="store_form" type="text" class="form-control is-invalid p-street-address" name="store_adnum" id="store_adnum" value="{{old('store_adnum')}}" aria-describedby="store_adnum-error" aria-invalid="true">
                <span id="store_adnum-error" class="error invalid-feedback">{{$errors->first('store_adnum')}}</span>
                @else
                <input form="store_form" type="text" class="form-control p-street-address" id="store_adnum" name="store_adnum" value="{{ old('store_adnum', $store->store_adnum) }}">
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="store_apart" class="col-sm-2 col-form-label">@lang('common.apart')</label>
              <div class="col-sm-10">
                @if($errors->has('store_apart'))
                <input form="store_form" type="text" class="form-control is-invalid p-extended-address" name="store_apart" id="store_apart" value="{{old('store_apart')}}" aria-describedby="store_apart-error" aria-invalid="true">
                <span id="store_apart-error" class="error invalid-feedback">{{$errors->first('store_apart')}}</span>
                @else
                <input form="store_form" type="text" class="form-control p-extended-address" id="store_apart" name="store_apart" value="{{ old('store_apart', $store->store_apart) }}">
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="store_phone_number" class="col-sm-2 col-form-label">@lang('common.phone_number') @include('partials.required')</label>
              <div class="col-sm-10">
                @if($errors->has('store_phone_number'))
                <input form="store_form" type="tel" class="form-control is-invalid" name="store_phone_number" id="store_phone_number" value="{{old('store_phone_number')}}" aria-describedby="store_phone_number-error" aria-invalid="true" placeholder="@lang('common.phone_pholeder')">
                <span id="store_phone_number-error" class="error invalid-feedback">{{$errors->first('store_phone_number')}}</span>
                @else
                <input form="store_form" type="tel" class="form-control" id="store_phone_number" name="store_phone_number" value="{{ old('store_phone_number', $store->store_phone_number) }}" placeholder="@lang('common.phone_pholeder')">
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="store_fax_number" class="col-sm-2 col-form-label">@lang('common.fax_number')</label>
              <div class="col-sm-10">
                <input form="store_form" type="tel" class="form-control @error('store_fax_number') is-invalid @enderror" id="store_fax_number" name="store_fax_number" value="{{ old('store_fax_number', $store->store_fax_number) }}" placeholder="@lang('common.fax_pholeder')" @error('store_fax_number') aria-describedby="store_fax_number-error" aria-invalid="true" @enderror>
                @error('store_fax_number')
                <span id="store_fax_number-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="form-group row">
              <label for="store_email" class="col-sm-2 col-form-label">@lang('store.email')</label>
              <div class="col-sm-10">
                <input form="store_form" type="email" class="form-control @error('store_email') is-invalid @enderror" id="store_email" name="store_email" value="{{ old('store_email', $store->store_email) }}" @error('store_email') aria-describedby="store_email-error" aria-invalid="true" @enderror>
                @error('store_email')
                <span id="store_email-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="form-group row">
              <label for="store_url" class="col-sm-2 col-form-label">@lang('store.url')</label>
              <div class="col-sm-10">
                @if($errors->has('store_url'))
                <input form="store_form" type="url" class="form-control is-invalid" name="store_url" id="store_url" value="{{ old('store_url', $store->store_url) }}" aria-describedby="store_url-error" aria-invalid="true">
                <span id="store_url-error" class="error invalid-feedback">{{$errors->first('store_url')}}</span>
                @else
                <input form="store_form" type="url" class="form-control" id="store_url" name="store_url" value="{{old('store_url')}}">
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="flyer_img" class="col-sm-2 col-form-label">@lang('store.flyer')</label>
              <div class="col-sm-10">
                @if($errors->has('flyer_img'))
                <input form="store_form" type="text" class="form-control is-invalid" name="flyer_img" id="flyer_img" value="{{ old('flyer_img', $store->flyer_img) }}" aria-describedby="flyer_img-error" aria-invalid="true">
                <span id="flyer_img-error" class="error invalid-feedback">{{$errors->first('flyer_img')}}</span>
                @else
                <input form="store_form" type="text" class="form-control" id="flyer_img" name="flyer_img" value="{{old('flyer_img')}}">
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="floor_guide" class="col-sm-2 col-form-label">@lang('store.floor')</label>
              <div class="col-sm-10">
                @if($errors->has('floor_guide'))
                <input form="store_form" type="text" class="form-control is-invalid" name="floor_guide" id="floor_guide" value="{{ old('floor_guide', $store->floor_guide) }}" aria-describedby="floor_guide-error" aria-invalid="true">
                <span id="floor_guide-error" class="error invalid-feedback">{{$errors->first('floor_guide')}}</span>
                @else
                <input form="store_form" type="text" class="form-control" id="floor_guide" name="floor_guide" value="{{old('floor_guide')}}">
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">@lang('store.pause_flag') @include('partials.required') </label>
              <div class="col-sm-10">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-outline-info">
                    <input form="store_form" type="radio" name="pause_flag" id="pause_flag1" value="1" {{ old('pause_flag' , $store->pause_flag ) == '1' ? 'checked' : '' }}>@lang('store.show')
                  </label>
                  <label class="btn btn-outline-info">
                    <input form="store_form" type="radio" name="pause_flag" id="pause_flag0" value="0" {{ old('pause_flag' , $store->pause_flag ) == '0' ? 'checked' : '' }}>@lang('store.hide')
                  </label>
                </div>
                @if($errors->has('pause_flag'))
                <div class="small text-danger">{{$errors->first('pause_flag')}}</div>
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="store_info" class="col-sm-2 col-form-label">@lang('store.info')</label>
              <div class="col-sm-10">
                @if($errors->has('store_info'))
                <textarea form="store_form" class="form-control is-invalid" name="store_info" id="store_info" value="{{ old('store_info') }}" aria-describedby="store_info-error" aria-invalid="true">{{old('store_info')}}</textarea>
                <span id="store_info-error" class="error invalid-feedback">{{$errors->first('store_info')}}</span>
                @else
                <textarea form="store_form" class="form-control" id="store_info" name="store_info" value="{{ old('store_info',$store->store_info) }}">{{ old('store_info',$store->store_info) }}</textarea>
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="pay_info" class="col-sm-2 col-form-label">@lang('store.pay_info')</label>
              <div class="col-sm-10">
                @if($errors->has('pay_info'))
                <textarea form="store_form" class="form-control is-invalid" name="pay_info" id="pay_info" value="{{ old('pay_info') }}" aria-describedby="pay_info-error" aria-invalid="true">{{old('pay_info')}}</textarea>
                <span id="pay_info-error" class="error invalid-feedback">{{$errors->first('pay_info')}}</span>
                @else
                <textarea form="store_form" class="form-control" id="pay_info" name="pay_info" value="{{ old('pay_info',$store->pay_info) }}">{{ old('pay_info',$store->pay_info) }}</textarea>
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="access" class="col-sm-2 col-form-label">@lang('store.access')</label>
              <div class="col-sm-10">
                @if($errors->has('access'))
                <textarea form="store_form" class="form-control is-invalid" name="access" id="access" value="{{ old('access') }}" aria-describedby="access-error" aria-invalid="true">{{old('access')}}</textarea>
                <span id="access-error" class="error invalid-feedback">{{$errors->first('access')}}</span>
                @else
                <textarea form="store_form" class="form-control" id="access" name="access" value="{{ old('access',$store->access) }}">{{ old('access',$store->access) }}</textarea>
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="opening_hour" class="col-sm-2 col-form-label">@lang('store.opening_hour')</label>
              <div class="col-sm-10">
                @if($errors->has('opening_hour'))
                <textarea form="store_form" class="form-control is-invalid" name="opening_hour" id="opening_hour" value="{{ old('opening_hour') }}" aria-describedby="opening_hour-error" aria-invalid="true">{{old('opening_hour')}}</textarea>
                <span id="opening_hour-error" class="error invalid-feedback">{{$errors->first('opening_hour')}}</span>
                @else
                <textarea form="store_form" class="form-control" id="opening_hour" name="opening_hour" value="{{ old('opening_hour',$store->opening_hour) }}">{{ old('opening_hour',$store->opening_hour) }}</textarea>
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="closed_day" class="col-sm-2 col-form-label">@lang('store.closed_day')</label>
              <div class="col-sm-10">
                @if($errors->has('closed_day'))
                <textarea form="store_form" class="form-control is-invalid" name="closed_day" id="closed_day" value="{{ old('closed_day') }}" aria-describedby="closed_day-error" aria-invalid="true">{{old('closed_day')}}</textarea>
                <span id="closed_day-error" class="error invalid-feedback">{{$errors->first('closed_day')}}</span>
                @else
                <textarea form="store_form" class="form-control" id="closed_day" name="closed_day" value="{{ old('closed_day',$store->closed_day) }}">{{ old('closed_day',$store->closed_day) }}</textarea>
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="parking" class="col-sm-2 col-form-label">@lang('store.parking')</label>
              <div class="col-sm-10">
                @if($errors->has('parking'))
                <textarea form="store_form" class="form-control is-invalid" name="parking" id="parking" value="{{ old('parking') }}" aria-describedby="parking-error" aria-invalid="true">{{old('parking')}}</textarea>
                <span id="parking-error" class="error invalid-feedback">{{$errors->first('parking')}}</span>
                @else
                <textarea form="store_form" class="form-control" id="parking" name="parking" value="{{ old('parking',$store->parking) }}">{{ old('parking',$store->parking) }}</textarea>
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="latitude" class="col-sm-2 col-form-label">@lang('common.latitude')</label>
              <div class="col-sm-10">
                <input id="latcheck" type="checkbox"> <small>編集する(住所を変更した場合は、自動で変更されます)</small>
                @if($errors->has('latitude'))
                <input form="store_form" type="text" class="form-control is-invalid p-extended-address" name="latitude" id="latitude" value="{{old('latitude')}}" aria-describedby="latitude-error" aria-invalid="true">
                <span id="latitude-error" class="error invalid-feedback">{{$errors->first('latitude')}}</span>
                @else
                <input form="store_form" type="text" class="form-control p-extended-address" id="latitude" name="latitude" value="{{ old('latitude', $lat ) }}" disabled>
                @endif

              </div>
            </div>
            <div class="form-group row">
              <label for="longitude" class="col-sm-2 col-form-label">@lang('common.longitude')</label>
              <div class="col-sm-10">
                <input id="lngcheck" type="checkbox"> <small>編集する(住所を変更した場合は、自動で変更されます)</small>
                @if($errors->has('longitude'))
                <input form="store_form" type="text" class="form-control is-invalid p-extended-address" name="longitude" id="longitude" value="{{old('longitude')}}" aria-describedby="longitude-error" aria-invalid="true">
                <span id="longitude-error" class="error invalid-feedback">{{$errors->first('longitude')}}</span>
                @else
                <input form="store_form" type="text" class="form-control p-extended-address" id="longitude" name="longitude" value="{{ old('longitude', $lng ) }}" disabled>
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">@lang('store.photo')</label>
              <div class="col-sm-10">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#imgModal">
                  <i class="fas fa-cloud-upload-alt"></i> @lang('store.upload')
                </button>
              </div>
            </div>
            <div class="form-group row">
              <label for="store_img1" class="col-sm-2 col-form-label">@lang('store.img01')</label>
              <div class="col-sm-10">
                <div @error('store_img1') class="select2-has-error" @enderror>
                  <select form="store_form" class="form-control select2 img01-ajax is-invalid" id="store_img1" name="store_img1" style="width: 100%;">
                    <option value="{{ old('store_img1', $store->store_img1) }}">{{ old('store_img1',$store->store_img1) }}</option>
                  </select>
                  @if($errors->has('store_img1'))
                  <span id="store_img1-error" class="error invalid-feedback">{{$errors->first('store_img1')}}</span>
                  @endif
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="store_img2" class="col-sm-2 col-form-label">@lang('store.img02')</label>
              <div class="col-sm-10">
                <div @error('store_img2') class="select2-has-error" @enderror>
                  <select form="store_form" class="form-control select2 img02-ajax is-invalid" id="store_img2" name="store_img2" style="width: 100%;">
                    <option value="{{ old('store_img2',$store->store_img2) }}">{{ old('store_img2',$store->store_img2) }}</option>
                  </select>
                  @if($errors->has('store_img2'))
                  <span id="store_img2-error" class="error invalid-feedback">{{$errors->first('store_img2')}}</span>
                  @endif
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="store_img3" class="col-sm-2 col-form-label">@lang('store.img03')</label>
              <div class="col-sm-10">
                <div @error('store_img3') class="select2-has-error" @enderror>
                  <select form="store_form" class="form-control select2 img03-ajax is-invalid" id="store_img3" name="store_img3" style="width: 100%;">
                    <option value="{{ old('store_img3',$store->store_img3) }}">{{ old('store_img3',$store->store_img3) }}</option>
                  </select>
                  @if($errors->has('store_img3'))
                  <span id="store_img3-error" class="error invalid-feedback">{{$errors->first('store_img3')}}</span>
                  @endif
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="store_img4" class="col-sm-2 col-form-label">@lang('store.img04')</label>
              <div class="col-sm-10">
                <div @error('store_img4') class="select2-has-error" @enderror>
                  <select form="store_form" class="form-control select2 img04-ajax is-invalid" id="store_img4" name="store_img4" style="width: 100%;">
                    <option value="{{ old('store_img4',$store->store_img4) }}">{{ old('store_img4',$store->store_img4) }}</option>
                  </select>
                  @if($errors->has('store_img4'))
                  <span id="store_img4-error" class="error invalid-feedback">{{$errors->first('store_img4')}}</span>
                  @endif
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label for="store_img5" class="col-sm-2 col-form-label">@lang('store.img05')</label>
              <div class="col-sm-10">
                <div @error('store_img5') class="select2-has-error" @enderror>
                  <select form="store_form" class="form-control select2 img05-ajax is-invalid" id="store_img5" name="store_img5" style="width: 100%;">
                    <option value="{{ old('store_img5',$store->store_img5) }}">{{ old('store_img5',$store->store_img5) }}</option>
                  </select>
                  @if($errors->has('store_img5'))
                  <span id="store_img5-error" class="error invalid-feedback">{{$errors->first('store_img5')}}</span>
                  @endif
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label for="industry_id" class="col-sm-2 col-form-label">
                @lang('store.industry')
                @include('partials.required')
              </label>
              <div class="col-sm-10">
                <select form="store_form" name="industry_id" class="form-control">
                  @foreach($industry as $key)
                  @if($store->industry_id == $key->id)
                  <option value="{{$key->id}}" selected>{{ $key->industry_name }}</option>
                  @else
                  <option value="{{$key->id}}">{{ $key->industry_name }}</option>
                  @endif
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <!-- /.card-body -->
          <div class="card-footer">
            <form id="store_form" method="POST" action="{{ route('stores.update', $store->id) }}" enctype="multipart/form-data" class="inline_form">
              @csrf
              @method('PATCH')
              <input form="store_form" type="hidden" name="company_id" value="{{$company_id}}">
              <input form="store_form" type="hidden" name="id" value="{{$store->id}}">
              <button type="submit" class="btn btn-primary"><i class="fa fa-check-square"></i> @lang('store.edit.submit')</button>
            </form>
            <button class="btn btn-default float-right" onclick="location.href='{{ route('stores.index') }}'"><i class="fa fa-reply"></i> @lang('common.cancel')</button>
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->
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
        <h5 class="modal-title" id="exampleModalLabel">@lang('store.upload')</h5>
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

@section('right-sidebar')
    <div class="os-padding text-sm">
        <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
            <div class="os-content" style="padding: 16px; height: 100%; width: 100%;">
                <h5>店舗の編集</h5>
                <hr class="mb-2">
                <p>登録済み店舗情報の編集ができます。</p>
                <dl>
                  <dt>店舗コード</dt>
                  <dd>店舗を識別するためのコードを入力してください。(半角英数のみ)</dd>
                  <dt>店舗名</dt>
                  <dd>店舗名を入力してください。</dd>
                  <dt>店舗名かな</dt>
                  <dd>店舗名をひらがなで入力してください。</dd>
                  <dt>郵便番号</dt>
                  <dd>店舗所在地の郵便番号をハイフンありで入力してください。</dd>
                  <dt>都道府県</dt>
                  <dd>店舗所在地の都道府県名を入力してください。</dd>
                  <dt>市区町村</dt>
                  <dd>店舗所在地の市区町村を入力してください。</dd>
                  <dt>町名・番地</dt>
                  <dd>店舗所在地の町名・番地を入力してください。</dd>
                  <dt>ビル、マンション名</dt>
                  <dd>店舗所在地のビル、マンション名を入力してください。</dd>
                  <dt>電話番号</dt>
                  <dd>店舗の電話番号を入力してください。</dd>
                  <dt>FAX番号</dt>
                  <dd>店舗のFAX番号を入力してください。</dd>
                  <dt>店舗メールアドレス</dt>
                  <dd>店舗のe-mailアドレスを入力してください。</dd>
                  <dt>店舗ホームページ</dt>
                  <dd>店舗のホームページのURLを入力してください。</dd>
                  <dt>チラシ画像名</dt>
                  <dd>店舗のチラシがある場合は、店舗画像にアップロードしたファイル名を入力することでサイト上に表示されます。</dd>
                  <dt>店内見取図画像名</dt>
                  <dd>店内の見取り図画像がある場合は、店舗画像にアップロードしたファイル名を入力することでサイト上に表示されます。</dd>
                  <dt>店舗状態</dt>
                  <dd>サイト上に店舗を「表示」するか、「非表示」にするかを選択出来ます。</dd>
                  <dt>店舗からのお知らせ</dt>
                  <dd>店舗からのお知らせを登録できます。登録することでサイト上に表示されます。</dd>
                  <dt>決済方法</dt>
                  <dd>お店で使える決済方法を登録設定することで設定することですることでサイト上に表示されます。</dd>
                  <dt>アクセス</dt>
                  <dd>お店への行き方や場所の詳細などを登録できます。登録することでサイト上に表示されます。</dd>
                  <dt>営業時間</dt>
                  <dd>お店の営業時間を登録できます。登録することでサイト上に表示されます。</dd>
                  <dt>定休日</dt>
                  <dd>お店の定休日を登録できます。登録することでサイト上に表示されます。</dd>
                  <dt>駐車場</dt>
                  <dd>お店の駐車場情報を登録できます。登録することでサイト上に表示されます。</dd>
                  <dt>緯度・経度</dt>
                  <dd>緯度・経度の値は住所を変更した場合、自動で変更されます。地図上に表示されるお店の位置がずれる場合は、「編集する」をクリックして、手動で緯度・経度を入力してください。</dd>
                  <dt>店舗画像</dt>
                  <dd>店舗画像のアップロードが出来ます。アップロードした画像は、「画像管理＞店舗画像管理」より確認できます。アップロードした画像を、店舗画像1～5枚目に登録することで、サイト上に表示されます。</dd>
                  <dt>店舗画像1枚目～店舗画像5枚目</dt>
                  <dd>アップロード済みの画像ファイル名を入力してください。登録することでサイト上に表示されます。</dd>
                  <dt>業種設定</dt>
                  <dd>店舗の業種設定が可能です。設定することで、エンドユーザーが業種を選択して絞り込みを行ったとき、サイト上に表示することができます。</dd>
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
@stop

@section('js')
<script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
<script src="{{ asset('js/dropzone.min.js') }}" rel="stylesheet"></script>
<script src="{{ asset('js/storeimg_select.js') }}" rel="stylesheet"></script>
<script type="text/javascript">
  $('#latcheck').change(function() {
 //disabled属性の状態を取得する
 var result = $('#latitude').prop('disabled');
 
 if(result) {
     //disabled属性を付与する
     $('#latitude').prop('disabled', false);
 }
 else {
     //disabled属性を解除する
     $('#latitude').prop('disabled', true);
 }
})

$('#lngcheck').change(function() {
 //disabled属性の状態を取得する
 var result = $('#longitude').prop('disabled');
 
 if(result) {
     //disabled属性を付与する
     $('#longitude').prop('disabled', false);
 }
 else {
     //disabled属性を解除する
     $('#longitude').prop('disabled', true);
 }
})


</script>
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
@extends('adminlte::top-page')

@section('title', 'Storemap：ストアマップ / 個人情報保護方針')

{{-- @section('content_header')
<h1>ストアマップ / 個人情報保護方針</h1>
@stop --}}

@section('content_top_nav_left')

@stop

@section('content_top_nav_right')
{{-- ヘッダー右エリア --}}
@stop

{{-- @section('content_header')

@stop --}}

@section('content')

<section class="content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-user-lock"></i>
              個人情報保護方針
            </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <blockquote>
              <h5>個人情報保護方針</h5>
              <p>メジェド合同会社（以下「当社」といいます）は、「ユーザーに価値のある情報を提供、並びに、創出し続けることで社会貢献を果たす」という企業理念の下、さまざまな情報提供サービスを行っています。当社は、各種サービスにおいて、お客様よりお預かりした個人情報を保護し適切に取り扱うため、個人情報保護マネジメントシステムを策定するとともに、以下の個人情報保護方針を定め、当社で勤務するすべての役職員に周知し、この方針にしたがった個人情報の適切な保護に努めます。</p>
            <dl>
              <dt>1.個人情報保護管理体制の確立</dt>
              <dd>当社は、事業活動においてお預かりした個人情報を保護するための管理体制を確立します。</dd>
              <dt>2.個人情報の取得・利用・提供</dt>
              <dd>当社は、事業活動において個人情報を取得する際、事前に利用目的を特定します。個人情報の利用及び提供において適切に取り扱います。また、法令等に基づかない目的外利用を禁止するとともに、そのための処置を講じます。</dd>
              <dt>3.法令・規範の順守</dt>
              <dd>当社は、個人情報の取扱いに関する法令、国が定める指針その他の規範を遵守するとともに、当社の個人情報管理規則をこれらの法令及び指針、その他の規範に適合させます。</dd>
              <dt>4.安全管理の実施</dt>
              <dd>当社は、個人情報の正確性及び安全性を確保するため、想定されるリスクに見合う合理的な対策として、個人情報へのアクセス管理、個人情報の持ち出し手段の制限、外部からの不正アクセス防止策等を実施し、個人情報の漏洩、滅失又は毀損の防止に努めます。これらの安全策は定期的に見直すとともに、是正を行います。</dd>
              <dt>5.個人情報に関する開示等、苦情および相談への対応</dt>
              <dd>当社は、個人情報に関して当社が公表した手続きに基づいて本人から自己の情報の開示、訂正・追加・削除、または利用若しくは提供の拒否、並びに苦情及び相談の申し出を受けた場合、適切な本人確認を実施した上、すみやかに対応します。</dd>
              <dt>6.個人情報マネジメントシステムの策定・実施・維持および継続的改善</dt>
              <dd>当社は、当社で従事する従業者に個人情報保護の重要性を認識させ、個人情報を適切に利用し、保護するための個人情報保護マネジメントシステムを策定し、これを着実に実施、監視、維持し、継続的に改善します。</dd>
            </dl>
                        
              <p>制定：2020年10月20日<br>メジェド合同会社<br>代表社員　松田 智哉 </p>
              <small><cite title="Source Title">Privacy Policy</cite></small>
            </blockquote>

          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>


      <div class="col-12">
        @include('partials.footerlink')
      </div>
      <!-- /.row -->
    </div>
  </div><!-- /.container-fluid -->
</section>

@stop

@section('footer')
<div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
{!! config('const.manage.footer') !!}
@stop

@section('css')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@stop
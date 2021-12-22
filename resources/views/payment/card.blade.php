@extends('adminlte::page')

@section('title', 'カード情報登録 - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-12">
            <h1 class="m-0"><i class="far fa-credit-card"></i> {{ $company->company_name }} さま / @lang('payment.title')</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>
@stop

@section('content')
<section class="content">
    <div class="container-fluid">
        @include('partials.warning')
        @include('partials.success')
        <div id="select-course" class="row">
            <div class="col-md-6 col-12">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h5 class="m-0">フリー</h5>
                    </div>
                    <div class="card-body">
                        <div class="callout callout-secondary">
                            <h3><small class="h6 mr-1">月額</small>{{number_format(config('services.stripe.free_price')) }}<small class="h6 ml-1">円</small></h3>
                            <small>※無料で使ってみたいお店向け（※初回登録後１年間はベーシックプランと同じ機能が使えるキャンペーン中）</small>
                        </div>
                        <ul>
                            <li>{{number_format(config('services.stripe.free_item'))}}商品まで登録可能（※初回登録後1年間は{{number_format(config('services.stripe.basic_item'))}}まで登録可能）</li>
                            <li>画像容量{{config('services.stripe.free_storage_domination')}}まで利用可能（※初回登録後1年間は{{config('services.stripe.basic_storage_domination')}}まで利用可能）</li>
                            <li>1店舗は追加課金なしで利用可能</li>
                            <li>※初回登録後1年間はAPIの利用が可能</li>
                            <li>初期費用無料</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h5 class="m-0">ライト</h5>
                    </div>
                    <div class="card-body">
                        <div class="callout callout-info">
                            <h3><small class="h6 mr-1">月額</small>{{$price_list['light']}}<small class="h6 ml-1">円</small></h3>
                            <small>※お試しで使ってみたい店舗向け</small>
                        </div>
                        <ul>
                            <li>{{config('services.stripe.light_item')}}商品まで登録可能</li>
                            <li>画像容量{{config('services.stripe.light_storage_domination')}}まで利用可能</li>
                            <li>1店舗は追加課金なしで利用可能</li>
                            <li>{{$trial_date}}日の無料お試し期間</li>
                            <li>初期費用無料</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="card card-warning">
                    <div class="card-header">
                        <h5 class="m-0">ベーシック</h5>
                    </div>
                    <div class="card-body">
                        <div class="callout callout-warning">
                            <h3><small class="h6 mr-1">月額</small>{{$price_list['basic']}}<small class="h6 ml-1">円</small></h3>
                            <small>※取扱商品点数が多い店舗向け</small>
                        </div>
                        <ul>
                            <li>{{ number_format(config('services.stripe.basic_item')) }}商品まで登録可能</li>
                            <li>画像容量{{config('services.stripe.basic_storage_domination')}}まで利用可能</li>
                            <li>1店舗は追加課金なしで利用可能</li>
                            <li>{{$trial_date}}日の無料お試し期間</li>
                            <li>API連携が利用可能</li>
                            <li>初期費用無料</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h5 class="m-0">プレミアム</h5>
                    </div>
                    <div class="card-body">
                        <div class="callout callout-success">
                            <h3><small class="h6 mr-1">月額</small>{{$price_list['premium']}}<small class="h6 ml-1">円</small></h3>
                            <small>※取扱商品点数が非常に店舗向け</small>
                        </div>
                        <ul>
                            <li>{{ number_format(config('services.stripe.premium_item'))}}商品まで登録可能</li>
                            <li>画像容量{{config('services.stripe.premium_storage_domination')}}まで利用可能</li>
                            <li>1店舗は追加課金なしで利用可能</li>
                            <li>{{$trial_date}}日の無料お試し期間</li>
                            <li>API連携が利用可能</li>
                            <li>初期費用無料</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="card card-danger">
                    <div class="card-header">
                        <h5 class="m-0">追加店舗
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="callout callout-danger">
                            <h3><small class="h6 mr-1">月額</small>{{$price_list['add_store']}}<small class="h6 ml-1">円 / 1店舗</small></h3>
                            <small>※1店舗追加ごとに+{{$price_list['add_store']}}円</small>
                        </div>
                        <ul>
                            <li>1店舗ごとに+{{$price_list['add_store']}}円/月</li>
                            <li>{{$trial_date}}日の無料お試し期間</li>
                            <li>最初の1店舗は基本プラン内の料金に含まれています。<br>2店舗以上で運用の場合、必要になります</li>
                            <li>初期費用無料</li>
                        </ul>
                    </div>

                </div>
            </div>

            <!-- /.row -->
        </div>

        {{-- @dd($price_list,config('services.stripe.key'),config('services.stripe.premium_storage'),config('services.stripe.add_store'), config('services.stripe.light_price'), config('services.stripe.basic_price'),config('services.stripe.premium_price') ) --}}

        <div class="row">
            <!-- left column -->
            <div class="col-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h5 class="m-0">@lang('payment.first_input')</h5>
                    </div>
                    <div class="card-body">
                        <div id="app">
                            <div class="overlay-wrapper">
                                <div v-show="loading" class="overlay dark">
                                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                                    <div class="text-bold pt-2">Loading...</div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="card mb-4">
                                            <div class="card-body bg-light">
                                                <div v-if="!isSubscribed">
                                                    <div class="form-group">
                                                        <h6>プランを選択：</h6>
                                                        <select class="form-control plan" v-model="plan" @change="showPlan">
                                                            <option disabled value="">選択してください</option>
                                                            <option v-for="(value,key) in planOptions" :value="key" v-text="value">
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <h6>店舗数を選択：</h6>
                                                        <select class="form-control" v-model.number="storeNum" @change="changeStore">
                                                            <option disabled value="">選択してください</option>
                                                            @for ($i = 0; $i < 100; $i++) 
                                                                <option value="{{ $i }}">{{ $i + 1 }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <h6>カード名義人名：</h6>
                                                        <input type="text" class="form-control" v-model="cardHolderName" placeholder="名義人（半角ローマ字）">
                                                    </div>
                                                    <div class="form-group">
                                                        <h6>カード番号・有効期限・セキュリティコード：</h6>
                                                        <div id="new-card" class="bg-white"></div>
                                                    </div>
                                                    <div class="form-group text-right">
                                                        <button type="button" class="btn btn-primary" data-secret="{{ $intent->client_secret }}" @click="subscribe">
                                                            課金する
                                                        </button>
                                                    </div>
                                                </div>
                                                <div v-else-if="isSubscribed">
                                                    <div v-if="isCancelled">
                                                        キャンセル済みです。（終了：<span v-text="details.end_date"></span>）
                                                        <button class="btn btn-info" type="button" @click="resume">元に戻す</button>
                                                    </div>
                                                    <!-- 課金中 -->
                                                    <div v-else>
                                                        <h4>契約内容の変更</h4>
                                                        <div class="form-group">
                                                            契約中のプラン： <span v-text="details.plan"></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <select class="form-control plan" v-model="plan" @change="showPlan">
                                                                <option disabled value="">選択してください</option>
                                                                <option v-for="(value,key) in planOptions" :value="key" v-text="value"></option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            登録可能店舗数： <span v-text="details.quantity"></span>&nbsp;店
                                                        </div>
                                                        <div class="form-group">
                                                            <select class="form-control" v-model.number="storeNum" @change="changeStore">
                                                                <option disabled value="">選択してください</option>
                                                                @for ($i = 0; $i < 100; $i++) 
                                                                    <option value="{{ $i }}">{{ $i + 1 }}</option>
                                                                @endfor
                                                            </select><br>
                                                            <button class="btn btn-success" type="button" @click="changePlan"><i class="far fa-check-circle"></i> プランを変更する</button>
                                                        </div>
                                                        <hr>
                                                        <h4>お支払いカード情報の変更</h4>
                                                        <div class="form-group">
                                                            現在のカード情報(下４桁)： <b><span v-text="details.card_last_four"></span></b>
                                                        </div>
                                                        <div class="form-group">
                                                            <h6>カード名義人名：</h6>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" v-model="cardHolderName" placeholder="名義人（半角ローマ字）">
                                                        </div>
                                                        <div class="form-group">
                                                            <h6>カード番号・有効期限・セキュリティコード：</h6>
                                                        </div>
                                                        <div class="form-group">
                                                            <div id="update-card" class="bg-white"></div><br>
                                                            <button type="button" class="btn btn-secondary" data-secret="{{ $intent->client_secret }}" @click="updateCard">
                                                                <i class="far fa-credit-card"></i> クレジットカードを変更する
                                                            </button>
                                                        </div>
                                                        <hr>
                                                        <h4>契約のキャンセル</h4>
                                                        <div class="mb-3">現在、課金中です。</div>
                                                        <button class="btn btn-warning" type="button" @click="cancel"><i class="far fa-times-circle"></i> キャンセルする</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <h5>サイト登録後 {{$trial_date}}日間は、ベーシックプランと同じ内容を無料でご利用いただけます</h5>
                                                <hr>
                                                <strong>決済代行会社：</strong> Stripe<br>
                                                <strong>有効期限について：</strong> 有効期限が切れる７日前にメールでお知らせ致します。<br>
                                                ※お支払い情報は暗号化してStripe社へ送信されます。<br>
                                                カード番号はStripe社へ送信されます。セキュリティ強化のため、弊社ではカード番号の保存は致しません。
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        @if($company->hasDefaultPaymentMethod())
                                        <p id="firstdate" class="lead">現在のご請求金額</p>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th style="width:30%">現在のプラン:</th>
                                                        <td style="width:30%" class="text-right">{{ $plan }}</td>
                                                        <td style="width:40%" class="text-right">{{ $laprice }}&nbsp;円</td>
                                                    </tr>
                                                    <tr>
                                                        <th>登録可能店舗数:</th>
                                                        <td class="text-right">{{ $stores_quantity }}&nbsp;店</td>
                                                        <td class="text-right">{{ $stores_price }}&nbsp;円</td>
                                                    </tr>
                                                    <tr>
                                                        <th>合計(税込):</th>
                                                        <td></td>
                                                        <td class="text-right">{{ $stores_price + $laprice }}&nbsp;円</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            @if($trial_ends)
                                            <h6>無料期間：{{$trial_ends}}まで</h6>
                                            @endif
                                        </div>
                                        <span v-show="!existenceShow">
                                            <hr class="mt-5">
                                            <p class="lead">契約内容を変更した場合の見積金額</p>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <th style="width:30%">変更後のプラン:</th>
                                                            <td style="width:30%" class="text-right"><span v-show="!planShow">@{{ planName }}</span></td>
                                                            <td style="width:40%" class="text-right">@{{ planPrice | number_format }}&nbsp;円</td>
                                                        </tr>
                                                        <tr>
                                                            <th>登録可能店舗数:</th>
                                                            <td class="text-right"><span v-show="!storeShow">@{{ storeAdd }}&nbsp;店</span></td>
                                                            <td class="text-right">@{{ storePrice | number_format }}&nbsp;円</td>
                                                        </tr>
                                                        <tr>
                                                            <th>合計(税込):</th>
                                                            <td></td>
                                                            <td class="text-right">@{{ totalPrice | number_format }}&nbsp;円</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </span>
                                        @else
                                        <p class="lead">お見積り<span class="text-sm">(サイト登録後 {{$trial_date}}日間は、ベーシックプランと同じ内容を無料でご利用いただけます)</span></p>
                                        @if($trial)
                                        <h6>無料期間：{{$trial}}まで</h6>
                                        @endif
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th style="width:30%">プラン:</th>
                                                        <td style="width:30%" class="text-right"><span v-show="!planShow">@{{ planName }}</span></td>
                                                        <td style="width:40%" class="text-right">@{{ planPrice | number_format }}&nbsp;円</td>
                                                    </tr>
                                                    <tr>
                                                        <th>店舗数:</th>
                                                        <td class="text-right"><span v-show="!storeShow">@{{ storeAdd }}&nbsp;店</span></td>
                                                        <td class="text-right">@{{ storePrice | number_format }}円</td>
                                                    </tr>
                                                    <tr>
                                                        <th>合計(税込):</th>
                                                        <td></td>
                                                        <td class="text-right">@{{ totalPrice | number_format }}&nbsp;円</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        @endif
                                        {{-- @isset($invoices)
                                        <p class="lead">領収書</p>
                                        <table>
                                            @foreach ($invoices as $invoice)
                                                <tr>
                                                    <td>{{ $invoice->date()->toFormattedDateString() }}</td>
                                        <td>{{ $invoice->total() }}</td>
                                        <td><a href="/company/invoice/{{ $invoice->id }}" target="_blank">領収書をダウンロード</a></td>
                                        </tr>
                                        @endforeach
                                        </table>
                                        @endisset --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
    </div><!-- /.container-fluid -->
</section>
@stop

@section('right-sidebar')
<div class="os-padding text-sm">
    <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
        <div class="os-content" style="padding: 16px; height: 100%; width: 100%;">
            <h5>お支払い情報の登録・変更</h5>
            <hr class="mb-2">
            <p>お支払い情報の登録・変更ができます。</p>
            <p>不正利用防止と本人確認のため、最初にお支払い情報の登録をお願いしております。※初回{{$trial_date}}日は無料でご利用いただけます。</p>
            <h5>各プランについて</h5>
            <dl>
                <dt>ライトプラン</dt>
                <dd>月額{{$price_list['light']}}円。お試しで使ってみたい店舗向けのプランです。<br>
                    ・{{config('services.stripe.light_item')}}商品まで登録可能<br>
                    ・画像容量{{config('services.stripe.light_storage_domination')}}まで利用可能<br>
                    ・1店舗は追加課金なしで利用可能<br>
                    ・{{$trial_date}}日の無料お試し期間<br>
                    ・初期費用無料</dd>
                <dt>ベーシックプラン</dt>
                <dd>月額{{$price_list['basic']}}円。取扱商品点数が多い店舗向けのプランです。<br>
                    ・{{ number_format(config('services.stripe.basic_item')) }}商品まで登録可能<br>
                    ・画像容量{{config('services.stripe.basic_storage_domination')}}まで利用可能<br>
                    ・1店舗は追加課金なしで利用可能<br>
                    ・{{$trial_date}}日の無料お試し期間<br>
                    ・初期費用無料</dd>
                <dt>プレミアムプラン</dt>
                <dd>月額{{$price_list['premium']}}円。※取扱商品点数が非常に多い店舗向けのプランです。<br>
                    ・{{ number_format(config('services.stripe.premium_item'))}}商品まで登録可能<br>
                    ・画像容量{{config('services.stripe.premium_storage_domination')}}まで利用可能<br>
                    ・1店舗は追加課金なしで利用可能<br>
                    ・{{$trial_date}}日の無料お試し期間<br>
                    ・初期費用無料</dd>
                <dt>追加店舗</dt>
                <dd>月額{{$price_list['add_store']}}円。※1店舗追加ごとに+{{$price_list['add_store']}}円必要です。<br>
                    ・登録店舗数を増やす場合に入力してください<br>
                    ・店舗数を増やすことで、登録した商品情報の共有が可能になります<br>
                    ・1店舗はプラン内の料金に含まれているため、追加課金なしで利用可能です<br>
                    ・{{$trial_date}}日の無料お試し期間<br>
                    ・初期費用無料</dd>
            </dl>
            <h5>お支払い情報について</h5>
            <p>決済の代行にStripeを利用しております。セキュリティ強化のためカード番号はSSL(情報暗号化通信)にてStripe社へ直接送信し、弊社ではカード番号の保存は致しません。<br>カードの有効期限切れについては、７日前にメールでお知らせいたします。</p>
            <dl>
                <dt>ライトプラン</dt>
                <dd>月額{{$price_list['light']}}円。お試しで使ってみたい店舗向けのプランです。<br>
                    ・{{config('services.stripe.light_item')}}商品まで登録可能<br>
                    ・画像容量{{config('services.stripe.light_storage_domination')}}まで利用可能<br>
                    ・1店舗は追加課金なしで利用可能<br>
                    ・{{$trial_date}}日の無料お試し期間<br>
                    ・初期費用無料</dd>
                <dt>ベーシックプラン</dt>
                <dd>月額{{$price_list['basic']}}円。取扱商品点数が多い店舗向けのプランです。<br>
                    ・{{ number_format(config('services.stripe.basic_item')) }}商品まで登録可能<br>
                    ・画像容量{{config('services.stripe.basic_storage_domination')}}まで利用可能<br>
                    ・1店舗は追加課金なしで利用可能<br>
                    ・{{$trial_date}}日の無料お試し期間<br>
                    ・初期費用無料</dd>
                <dt>プレミアムプラン</dt>
                <dd>月額{{$price_list['premium']}}円。※取扱商品点数が非常に多い店舗向けのプランです。<br>
                    ・{{ number_format(config('services.stripe.premium_item'))}}商品まで登録可能<br>
                    ・画像容量{{config('services.stripe.premium_storage_domination')}}まで利用可能<br>
                    ・1店舗は追加課金なしで利用可能<br>
                    ・{{$trial_date}}日の無料お試し期間<br>
                    ・初期費用無料</dd>
                <dt>追加店舗</dt>
                <dd>月額{{$price_list['add_store']}}円。※1店舗追加ごとに+{{$price_list['add_store']}}円必要です。<br>
                    ・登録店舗数を増やす場合に入力してください<br>
                    ・店舗数を増やすことで、登録した商品情報の共有が可能になります<br>
                    ・1店舗分はプラン側の料金に含まれているため、追加課金なしで利用可能です<br>
                    ・{{$trial_date}}日の無料お試し期間<br>
                    ・初期費用無料</dd>
            </dl>
        </div>
    </div>
</div>
@stop

@section('footer')
<div class="float-right d-none d-sm-block">{!! config('const.manage.version') !!}</div>
{!! config('const.manage.footer') !!}
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
<link rel="stylesheet" href="{{ asset('css/stripe.css') }}">
@stop

@section('js')
<script src="https://js.stripe.com/v3/"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.min.js"></script>
<script src="https://unpkg.com/vue-toasted"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>


<script>
    var options = {
        position: 'top-center',
        duration: 20000,
        fullWidth: false,
        type: 'error'
    }
    var successOptions = {
        position: 'top-center',
        duration: 20000,
        fullWidth: false,
        type: 'success'
    }

    // 数値を通貨書式「#,###,###」に変換するフィルター
    Vue.filter('number_format', function(val) {
        return val.toLocaleString();
    });

    Vue.use(Toasted);

    // 整形して改行入るとバグるので注意
    new Vue({
        el: '#app',
        data: {
            stripe: null,
            stripeCard: null,
            publicKey: '{{ config('services.stripe.key') }}',
            status: '',
            cardHolderName: '',
            details: {},
            plan: '',
            planOptions: {!! json_encode(config('services.stripe.plans')) !!},
            storeNum: '',
            loading: false,
            addStore: {{ config('services.stripe.add_store') }},
            // addStore: 1000,
            lightPlan: {{ config('services.stripe.light_price') }},
            // lightPlan: 1000,
            basicPlan: {{ config('services.stripe.basic_price') }},
            // basicPlan: 3000,
            prePlan: {{ config('services.stripe.premium_price') }},
            // prePlan: 5000,
            storeShow: true,
            planShow: true,
            existenceShow: true
        },
        methods: {
            async subscribe(e) {
                const paymentMethod = await this.getPaymentMethod(e.target);
                const url = '/payment/ajax/subscribe';
                const params = {
                    payment_method: paymentMethod,
                    plan: this.plan,
                    storeNum: this.storeNum
                };

                this.loading = true;

                axios.post(url, params)
                    .then(response => {
                        location.reload();
                        this.setStatus;
                        this.$toasted.show('ありがとうございます。画面が更新されるまでお待ちください。', successOptions);
                    }).catch(error => {
                        //失敗した時の処理
                        // this.$toasted.show('処理に失敗しました。入力内容をご確認下さい。', options);
                        this.$toasted.show(error.response.data.message, options);
                    })
                    .finally(() => {
                        this.loading = false; // 最終的に必ず実行
                    });
            },
            cancel() {
                const url = '/payment/ajax/cancel';

                this.loading = true;

                axios.post(url)
                    .then(this.setStatus)
                    .catch(error => {
                        //失敗した時の処理
                        // this.$toasted.show(error.message, options);
                        this.$toasted.show('処理に失敗しました。入力内容をご確認下さい。', options);
                        // console.log(error);
                    })
                    .finally(() => {
                        this.loading = false; // 最終的に必ず実行
                    });
            },
            resume() {
                const url = '/payment/ajax/resume';
                this.loading = true;
                axios.post(url)
                    .then(this.setStatus)
                    .catch(error => {
                        //失敗した時の処理
                        // this.$toasted.show(error.message, options);
                        this.$toasted.show('処理に失敗しました。入力内容をご確認下さい。', options);
                        // console.log(error);
                    })
                    .finally(() => {
                        this.loading = false; // 最終的に必ず実行
                    });
            },
            changePlan() {
                const url = '/payment/ajax/change_plan';
                const params = {
                    plan: this.plan,
                    storeNum: this.storeNum
                };
                // console.log(this.plan);
                this.loading = true; // 最終的に必ず実行

                axios.post(url, params)
                    // .then(this.setStatus)
                    .then(response => {
                        this.setStatus;
                        this.$toasted.show('変更に成功しました。画面が更新されるまでお待ちください。', successOptions);
                    })
                    .catch(error => {
                        //失敗した時の処理
                        // this.$toasted.show('処理に失敗しました。入力内容をご確認下さい。', options);
                        this.$toasted.show(error.response.data.message, options);
                        // console.log(error);
                    })
                    .finally(() => {
                        this.loading = false; // 最終的に必ず実行
                        location.reload();
                    });
            },
            async updateCard(e) {

                const paymentMethod = await this.getPaymentMethod(e.target);
                const url = '/payment/ajax/update_card';
                const params = {
                    payment_method: paymentMethod
                };

                this.loading = true;

                axios.post(url, params)
                    .then(response => {
                        location.reload();
                    }).catch(error => {
                        //失敗した時の処理
                        this.$toasted.show('処理に失敗しました。入力内容をご確認下さい。', options);
                        // this.$toasted.show(error.message, options);
                        // console.log(error);
                    })
                    .finally(() => {
                        this.loading = false; // 最終的に必ず実行
                    });
            },
            setStatus(response) {
                this.status = response.data.status;
                this.details = response.data.details;
            },
            async getPaymentMethod(target) {

                const clientSecret = target.dataset.secret;
                const {
                    setupIntent,
                    error
                } = await this.stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: this.stripeCard,
                            billing_details: {
                                name: this.cardHolderName
                            }
                        }
                    }
                );

                if (error) {
                    // this.$toasted.show(error.message, options);
                    // this.$toasted.show('処理に失敗しました。入力内容をご確認下さい。', options);
                    // console.log(error);
                } else {
                    return setupIntent.payment_method;
                }

            },
            changeStore: function changeStore(e) {
                this.existenceShow = false;
                this.storeShow = false;
            },
            showPlan: function showPlan(e) {
                this.existenceShow = false;
                this.planShow = false;
            },
        },
        computed: {
            isSubscribed() {
                return (this.status === 'subscribed' || this.status === 'cancelled');
            },
            isCancelled() {
                return (this.status === 'cancelled');
            },
            planName: function() {
                return this.planOptions[this.plan];
            },
            planPrice: function() {
                var courseVal = '';
                switch (this.planOptions[this.plan]) {
                    case 'ライト':
                        courseVal = this.lightPlan;
                        break;
                    case 'ベーシック':
                        courseVal = this.basicPlan;
                        break;
                    case 'プレミアム':
                        courseVal = this.prePlan;
                        break;
                }
                return courseVal;
            },
            storePrice: function() {
                return this.storeNum * this.addStore;
            },
            storeAdd: function() {
                return this.storeNum + 1;
            },
            // 合計金額（税込）を返す算出プロパティ
            totalPrice: function() {
                // 基本料金（税込）とオプション料金（税込）の合計を返す
                return (this.planPrice + this.storePrice);
            },
        },
        watch: {
            status(value) {
                Vue.nextTick(() => {
                    const selector = (value === 'unsubscribed') ? '#new-card' : '#update-card';
                    this.stripeCard = this.stripe.elements().create('card', {
                        hidePostalCode: true
                    });
                    this.stripeCard.mount(selector);
                });
            },
        },
        mounted() {
            this.stripe = Stripe(this.publicKey);
            const url = '/payment/ajax/status';

            this.loading = true;

            axios.get(url)
                .then(this.setStatus)
                .catch(error => {
                    //失敗した時の処理
                    // this.$toasted.show(error.message, options);
                    this.$toasted.show('処理に失敗しました。入力内容をご確認下さい。', options);
                    // console.log(error);
                })
                .finally(() => {
                    this.loading = false; // 最終的に必ず実行
                });
        }
    });
</script>
@stop
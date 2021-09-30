@extends('adminlte::page')

@section('title', 'マニュアル - Storemap Cockpit')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">マニュアル / HELP</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item active">マニュアル</li>
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
                <div class="card">

                    <div class="row p-3">
                        <div class="col-2">
                            <div class="list-group" id="list-tab" role="tablist">
                                <a class="list-group-item list-group-item-action active" id="list-company-list" data-toggle="list" href="#list-company" role="tab" aria-controls="company">1.会社情報</a>
                                <a class="list-group-item list-group-item-action" id="list-stores-list" data-toggle="list" href="#list-stores" role="tab" aria-controls="stores">2.店舗管理</a>
                                <a class="list-group-item list-group-item-action" id="list-categories-list" data-toggle="list" href="#list-categories" role="tab" aria-controls="categories">3.カテゴリ管理</a>
                                <a class="list-group-item list-group-item-action" id="list-items-list" data-toggle="list" href="#list-items" role="tab" aria-controls="items">4.商品管理</a>
                                <a class="list-group-item list-group-item-action" id="list-stock-list" data-toggle="list" href="#list-stock" role="tab" aria-controls="stock">5.在庫・価格管理</a>
                                <a class="list-group-item list-group-item-action" id="list-images-list" data-toggle="list" href="#list-images" role="tab" aria-controls="images">6.画像管理</a>
                                <a class="list-group-item list-group-item-action" id="list-catalog-list" data-toggle="list" href="#list-catalog" role="tab" aria-controls="catalog">7.カタログ出品</a>
                                <a class="list-group-item list-group-item-action" id="list-users-list" data-toggle="list" href="#list-users" role="tab" aria-controls="users">8.担当者管理</a>
                                <a class="list-group-item list-group-item-action" id="list-api-list" data-toggle="list" href="#list-api" role="tab" aria-controls="api">9.API設定</a>
                                <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">10.各種設定</a>
                                <a class="list-group-item list-group-item-action" id="list-contract-list" data-toggle="list" href="#list-contract" role="tab" aria-controls="contract">11.ご契約について</a>
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="list-company" role="tabpanel" aria-labelledby="list-company-list">
                                    <h3><b>1. 会社情報</b></h3>
                                    <hr>
                                    <dl class="paragraph-1">
                                        <dt>1-1. 会社情報について</dt>
                                        <dd>初回登録時に必ず会社情報を登録して頂く必要があります。<br>[設定 > 会社情報]をクリックすると、現在登録中の会社情報が表示されます。<br>会社情報を編集するボタンをクリックすることで編集が可能です。</dd>
                                        <dt>1-2. 会社情報の編集</dt>
                                        <dd>会社情報の編集画面では、登録済みの会社情報の変更が可能です。<br>
                                            ※必須と記載のある部分に関しては必ずご入力頂く必要があります。
                                        </dd>
                                        <dt>1-2-1. 管理責任者名</dt>
                                        <dd>Storemapに登録するデータを管理する責任者のお名前をご入力ください。トラブルが発生した場合の、弊社からご担当者さま宛にご連絡させて頂きます。</dd>
                                        <dt>1-2-2. 公開設定について</dt>
                                        <dd>会社情報の編集画面で公開設定を非公開にすると、全店舗非公開状態となります。<br>一時的にサイトへ表示させたくない場合は、非公開を選択してください。</dd>
                                        <dt>1-2-3. メーカー設定</dt>
                                        <dd>御社がGS1事業者コードを取得済みのメーカーの場合は、会社情報の編集画面でメーカーを選択することで、小売店側が御社の商品情報を参照して簡易出品が可能なカタログに掲載されます。カタログに商品情報を掲載することで、商品を取り扱っている小売店がJANコードのみで商品情報をコピーして利用することが出来ます。</dd>
                                        <dt>1-2-4. 他社画像利用 </dt>
                                        <dd>メーカー設定時のみ利用可能。他社の画像利用を許可するにチェックを入れると、他社が商品情報をコピーするときに画像も一緒にコピーされます。</dd>
                                        <dt>1-2-5. GS1事業者コード</dt>
                                        <dd>GS1事業者コードは、GTIN（JANコード）やGLNなどの国際標準の各種識別コード（GS1識別コード）を設定するために必要な番号です。JNAコードの前7桁または9桁の値になります。メーカー設定時のみ利用可能。</dd>
                                        <dt>1-2-6. 会社証明</dt>
                                        <dd>必須項目ではありませんが、トラブル時に解決が早くなる場合があります。開業届や法人設立届出書などをスキャンした画像。(※GS1事業者コードが重複した場合などの確認に必要)</dd>
                                    </dl>
                                </div>
                                <div class="tab-pane fade" id="list-stores" role="tabpanel" aria-labelledby="list-stores-list">
                                    <h3><b>2. 店舗管理</b></h3>
                                    <hr>
                                    <dl class="paragraph-1">
                                        <dt>2-1. 店舗管理について</dt>
                                        <dd>現在運営中の店舗情報を登録して下さい。登録することでユーザーが検索したときに、最寄りの店舗情報が表示されます。契約件数以上の店舗情報は登録できませんので、店舗を追加したい場合は[設定 > お支払い情報] より店舗を追加してください。</dd>
                                        <dt>2-2. 店舗一覧</dt>
                                        <dd>[店舗管理 > 店舗一覧]をクリックして頂くことで現在登録頂いている店舗の一覧が表示されます。カレンダーをクリックすることで、店舗のイベントカレンダーをご利用いただけます。詳細は店舗の編集が可能です。</dd>
                                        <dt>2-3. 店舗登録</dt>
                                        <dd>[店舗管理 > 店舗登録]をクリックして頂くことで新しく店舗を登録することが可能です。契約件数以上の店舗を登録することは出来ませんのでご注意ください。</dd>
                                        <dt>2-4. 登録済み店舗の編集方法</dt>
                                        <dd>[店舗管理 > 店舗一覧]をクリックして頂くことで現在登録頂いている店舗の一覧が表示されます。一覧より詳細をクリックすることで店舗の編集が可能です。
                                        </dd>
                                        <dt>2-5. 店舗の編集及び登録の設定値</dt>
                                        <dd>各項目については以下の設定値をご確認ください。
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="text-nowrap">@lang('csv.name')</th>
                                                        <th>@lang('csv.csv_name')</th>
                                                        <th>@lang('csv.explanation')</th>
                                                        <th class="text-nowrap">@lang('csv.limit')</th>
                                                        <th style="width:25%">@lang('csv.note')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>@lang('csv.store.code')</th>
                                                        <td>@lang('csv.store.store_code')</td>
                                                        <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.store.code_exp')</td>
                                                        <td>@lang('csv.string')(20)</td>
                                                        <td>@lang('csv.store.code_note')</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.store.name')</th>
                                                        <td>@lang('csv.store.store_name')</td>
                                                        <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.store.store_name_exp')</td>
                                                        <td>@lang('csv.string')(85)</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.store.kana')</th>
                                                        <td>@lang('csv.store.store_kana')</td>
                                                        <td>@lang('csv.store.store_kana_exp')</td>
                                                        <td>@lang('csv.string')(85)</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.store.postcode')</th>
                                                        <td>@lang('csv.store.store_postcode')</td>
                                                        <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.store.store_postcode_exp')</td>
                                                        <td>@lang('csv.jpzip')</td>
                                                        <td>@lang('csv.store.store_postcode_note')</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.store.pre')</th>
                                                        <td>@lang('csv.store.prefecture')</td>
                                                        <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.store.prefecture_exp')</td>
                                                        <td>@lang('csv.string')(4)</td>
                                                        <td>@lang('csv.store.prefecture_note')</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.store.city')</th>
                                                        <td>@lang('csv.store.store_city')</td>
                                                        <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.store.store_city_exp')</td>
                                                        <td>@lang('csv.string')(30)</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.store.adnum')</th>
                                                        <td>@lang('csv.store.store_adnum')</td>
                                                        <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.store.store_adnum_exp')</td>
                                                        <td>@lang('csv.string')(50)</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.store.apart')</th>
                                                        <td>@lang('csv.store.store_apart')</td>
                                                        <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.store.store_apart_exp')</td>
                                                        <td>@lang('csv.string')(100)</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.store.phone_number')</th>
                                                        <td>@lang('csv.store.store_phone_number')</td>
                                                        <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.store.store_phone_number_exp')</td>
                                                        <td>@lang('csv.tel')</td>
                                                        <td>@lang('csv.store.store_phone_number_note')</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.store.fax_number')</th>
                                                        <td>@lang('csv.store.store_fax_number')</td>
                                                        <td>@lang('csv.store.store_fax_number_exp')</td>
                                                        <td>@lang('csv.tel')</td>
                                                        <td>@lang('csv.store.store_fax_number_note')</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.store.email')</th>
                                                        <td>@lang('csv.store.store_email')</td>
                                                        <td>@lang('csv.store.store_email_exp')</td>
                                                        <td>@lang('csv.email')</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.store.flag')</th>
                                                        <td>@lang('csv.store.pause_flag')</td>
                                                        <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.store.pause_flag')</td>
                                                        <td>@lang('csv.bool_0')<br>@lang('csv.bool_1')</td>
                                                        <td>@lang('csv.store.pause_flag_note')</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.store.img1')</th>
                                                        <td>@lang('csv.store.store_img1')</td>
                                                        <td>@lang('csv.store.store_img_exp')</td>
                                                        <td>@lang('csv.img')</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.store.img2')</th>
                                                        <td>@lang('csv.store.store_img2')</td>
                                                        <td>@lang('csv.store.store_img_exp')</td>
                                                        <td>@lang('csv.img')</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.store.img3')</th>
                                                        <td>@lang('csv.store.store_img3')</td>
                                                        <td>@lang('csv.store.store_img_exp')</td>
                                                        <td>@lang('csv.img')</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.store.img4')</th>
                                                        <td>@lang('csv.store.store_img4')</td>
                                                        <td>@lang('csv.store.store_img_exp')</td>
                                                        <td>@lang('csv.img')</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.store.img5')</th>
                                                        <td>@lang('csv.store.store_img5')</td>
                                                        <td>@lang('csv.store.store_img_exp')</td>
                                                        <td>@lang('csv.img')</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.store.info')</th>
                                                        <td>@lang('csv.store.store_info')</td>
                                                        <td>@lang('csv.store.store_info_exp')</td>
                                                        <td>@lang('csv.string')</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.store.industry')</th>
                                                        <td>@lang('csv.store.industry_id')</td>
                                                        <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.store.industry_id_exp')</td>
                                                        <td>@lang('csv.num')</td>
                                                        <td>@lang('csv.store.industry_id_note')</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.store.url')</th>
                                                        <td>@lang('csv.store.store_url')</td>
                                                        <td>@lang('csv.store.store_url_exp')</td>
                                                        <td>@lang('csv.url')</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.store.flyer')</th>
                                                        <td>@lang('csv.store.flyer_img')</td>
                                                        <td>@lang('csv.store.flyer_img_exp')</td>
                                                        <td>@lang('csv.url')</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.store.floor')</th>
                                                        <td>@lang('csv.store.floor_guide')</td>
                                                        <td>@lang('csv.store.floor_guide_exp')</td>
                                                        <td>@lang('csv.url')</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('store.pay_info')</th>
                                                        <td>@lang('csv.store.pay_info')</td>
                                                        <td>@lang('csv.store.pay_info_exp')</td>
                                                        <td>@lang('csv.string')[500]</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('store.access')</th>
                                                        <td>@lang('csv.store.access')</td>
                                                        <td>@lang('csv.store.access_exp')</td>
                                                        <td>@lang('csv.string')[255]</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('store.opening_hour')</th>
                                                        <td>@lang('csv.store.opening_hour')</td>
                                                        <td>@lang('csv.store.opening_hour_exp')</td>
                                                        <td>@lang('csv.string')[255]</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('store.closed_day')</th>
                                                        <td>@lang('csv.store.closed_day')</td>
                                                        <td>@lang('csv.store.closed_day_exp')</td>
                                                        <td>@lang('csv.string')[255]</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('store.parking')</th>
                                                        <td>@lang('csv.store.parking')</td>
                                                        <td>@lang('csv.store.parking_exp')</td>
                                                        <td>@lang('csv.string')[255]</td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </dd>
                                        <dt>2-6. 店舗の削除</dt>
                                        <dd>[店舗管理 > 店舗一覧]をクリックして頂くことで現在登録頂いている店舗の一覧が表示されます。一覧より削除ボタンをクリックすることで店舗の削除が可能です。削除には管理者権限が必要です。</dd>
                                        <dt>2-7. 店舗カレンダー</dt>
                                        <dd>[店舗管理 > 店舗一覧]をクリックして頂くことで現在登録頂いている店舗の一覧が表示されます。一覧よりカレンダーをクリックすることで店舗カレンダーの編集が可能です。店舗カレンダーではお店のイベントや、開店時間、閉店時間、休業日等を記入することが出来ます。
                                            <dl class="paragraph-2">
                                                <dt>2-7-1. 店舗カレンダーの色</dt>
                                                <dd>店舗カレンダーでは視覚的にわかりやすいように、色が決められています。開店中は青色、予約は黄色、イベントやセールは緑色、閉店や休業は赤色、お店からのお知らせは灰色です。これらの区分に分けてご利用ください。</dd>
                                                <dt>2-7-2. テンプレートイベントの登録</dt>
                                                <dd>いつも利用する時間帯をテンプレートとして登録可能です。[テンプレートイベントの登録 > クリックして作成]より登録して保存してください。保存するとドラッグ＆ドロップで登録欄に項目が追加されます。追加したテンプレートイベントはカレンダー部分へドラッグ＆ドロップすることで、登録が可能になります。<br>例：開店中の時間帯を設定したい場合、タイトルに開店中と記入、開始時間と、終了時間に営業中の時間を入力、カラーは青色を選択して保存。※時間は23:59:59のように秒数まで記入してください。
                                                </dd>
                                                <dt>2-7-3. イベントの登録</dt>
                                                <dd>カレンダーの任意の日時をクリックすることで、イベントを新規登録することが可能です。</dd>
                                                <dt>2-7-4. イベントの編集</dt>
                                                <dd>登録済みのイベントをクリックすることで、イベントを編集することが可能です。</dd>
                                                <dt>2-7-5. イベントの削除</dt>
                                                <dd>登録済みのイベントをクリック後、スケジュールを変更画面で削除を押すことで、イベントの削除が可能です。</dd>
                                                <dt>2-7-6. テンプレートイベントの削除 </dt>
                                                <dd>ドラッグ＆ドロップで登録の項目にある、登録後に削除にチェックを入れて、カレンダー部分へドラッグ＆ドロップすることで、テンプレートイベントの削除が可能です。</dd>
                                            </dl>
                                        <dt>2-8. 店舗一括管理</dt>
                                        <dd>[店舗管理 > 店舗一括管理]をクリックすることで、csvファイルによる店舗情報の一括編集及び登録が可能です。ストアの一括ダウンロードをクリックすることで現在登録中の店舗一覧がcsvファイル形式で出力されます。ストアデータの一括更新より、参照ボタンを押してcsvファイルを選択し、アップロードボタンを押すことで一括編集が可能です。処理の結果は登録頂いているメールアドレス宛にメールで通知されます。csvファイルの各項目については、[2-4. 店舗の編集及び登録の設定]の値を参照してください。
                                        </dd>
                                    </dl>
                                </div>
                                <div class="tab-pane fade" id="list-categories" role="tabpanel" aria-labelledby="list-categories-list">
                                    <h3><b>3. カテゴリ管理</b></h3>
                                    <hr>
                                    <dl class="paragraph-1">
                                        <dt>3-1. カテゴリ管理について</dt>
                                        <dd>商品を分類するカテゴリを登録してください。ユーザーが店舗ページを表示した際に、カテゴリ一覧で商品が分類されて表示されます。</dd>
                                        <dt>3-2. カテゴリ一覧</dt>
                                        <dd>[カテゴリ管理 > カテゴリ一覧]をクリックすることで、現在登録中のカテゴリ一覧が表示されます。
                                        </dd>
                                        <dt>3-3. カテゴリ登録</dt>
                                        <dd>[カテゴリ管理 > カテゴリ登録]をクリックすることで、新規にカテゴリを登録することが出来ます。</dd>
                                        <dt>3-4. カテゴリの編集</dt>
                                        <dd>[カテゴリ管理 > カテゴリ一覧]より、編集ボタンをクリックすることで、登録済みカテゴリの内容を変更することが出来ます。</dd>
                                        <dt>3-5. カテゴリの編集及び登録の設定値</dt>
                                        <dd>各項目については以下の設定値をご確認ください。
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>@lang('csv.name')</th>
                                                        <th>@lang('csv.csv_name')</th>
                                                        <th>@lang('csv.explanation')</th>
                                                        <th class="text-nowrap">@lang('csv.limit')</th>
                                                        <th>@lang('csv.note')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>@lang('csv.category.code')</th>
                                                        <td>@lang('csv.category.category_code')</td>
                                                        <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.category.code_exp')</td>
                                                        <td>@lang('csv.string')(30)</td>
                                                        <td>@lang('csv.category.code_note')</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.category.name')</th>
                                                        <td>@lang('csv.category.category_name')</td>
                                                        <td>@lang('csv.category.category_exp')</td>
                                                        <td>@lang('csv.string')(125)</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.category.flag')</th>
                                                        <td>@lang('csv.category.display_flag')</td>
                                                        <td>@lang('csv.category.display_exp')</td>
                                                        <td>@lang('csv.bool_0')<br>@lang('csv.bool_1')</td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </dd>
                                        <dt>3-6. カテゴリの削除</dt>
                                        <dd>[カテゴリ管理 > カテゴリ一覧]をクリックして頂くことで現在登録頂いているカテゴリの一覧が表示されます。一覧より削除ボタンをクリックすることでカテゴリの削除が可能です。削除には管理者権限が必要です。</dd>
                                        <dt>3-7. カテゴリ一括管理</dt>
                                        <dd>[カテゴリ管理 > カテゴリ一括管理]をクリックすることで、csvファイルによるカテゴリ情報の一括編集及び登録が可能です。カテゴリデータの一括ダウンロードをクリックすることで現在登録中のカテゴリ一覧がcsvファイル形式で出力されます。カテゴリデータの一括更新より、参照ボタンを押してcsvファイルを選択し、アップロードボタンを押すことで一括編集が可能です。処理の結果は登録頂いているメールアドレス宛にメールで通知されます。csvファイルの各項目については、[3-5. カテゴリの編集及び登録の設定値]の値を参照してください。
                                        </dd>
                                    </dl>
                                </div>
                                <div class="tab-pane fade" id="list-items" role="tabpanel" aria-labelledby="list-items-list">
                                    <h3><b>4. 商品管理</b></h3>
                                    <hr>
                                    <dl class="paragraph-1">
                                        <dt>4-1. 商品管理について</dt>
                                        <dd>取扱中の商品を登録してください。ユーザーが検索したときに表示されます。</dd>
                                        <dt>4-2. 商品一覧</dt>
                                        <dd>[商品管理 > 商品一覧]をクリックすることで、現在登録中の商品一覧が表示されます。右上の検索バーより、商品コードや、商品名、JANコードでの検索も可能です。項目名をクリックすることで、ソートも可能です。
                                        </dd>
                                        <dt>4-3. 商品登録</dt>
                                        <dd>[商品管理 > 商品登録]をクリックすることで、新規に商品を登録することが出来ます。</dd>
                                        <dt>4-4. 商品の編集</dt>
                                        <dd>[商品管理 > 商品一覧]の商品一覧より、編集ボタンをクリックすることで、登録済み商品の内容を変更することが出来ます。</dd>
                                        <dt>4-5. 商品の編集及び登録の設定値</dt>
                                        <dd>csvの各項目については以下の設定値をご確認ください。
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>@lang('csv.name')</th>
                                                        <th>@lang('csv.csv_name')</th>
                                                        <th>@lang('csv.explanation')</th>
                                                        <th class="text-nowrap">@lang('csv.limit')</th>
                                                        <th>@lang('csv.note')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>@lang('csv.item.code')</th>
                                                        <td>@lang('csv.item.product_code')</td>
                                                        <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.item.code_exp')</td>
                                                        <td>@lang('csv.string')(40)</td>
                                                        <td>@lang('csv.item.code_note')</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.item.name')</th>
                                                        <td>@lang('csv.item.product_name')</td>
                                                        <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.item.product_name_exp')</td>
                                                        <td>@lang('csv.string')(255)</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.item.brand')</th>
                                                        <td>@lang('csv.item.brand_name')</td>
                                                        <td>@lang('csv.item.brand_exp')</td>
                                                        <td>@lang('csv.string')(100)</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.item.bar')</th>
                                                        <td>@lang('csv.item.barcode')</td>
                                                        <td>@lang('csv.item.barcode_exp')</td>
                                                        <td>@lang('csv.string')(20)</td>
                                                        <td>@lang('csv.item.barcode_note')</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.category.code')</th>
                                                        <td>@lang('csv.category.category_code')</td>
                                                        <td>カテゴリ管理で作成した、カテゴリコードを入力</td>
                                                        <td>@lang('csv.string')(30)</td>
                                                        <td>@lang('csv.category.code_note')</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.item.o_price')</th>
                                                        <td>@lang('csv.item.original_price')</td>
                                                        <td>@lang('csv.item.original_price_exp')</td>
                                                        <td>@lang('csv.num')(10)</td>
                                                        <td>@lang('csv.item.original_price_note')</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.item.flag')</th>
                                                        <td>@lang('csv.item.display_flag')</td>
                                                        <td>@lang('csv.item.display_flag_exp')</td>
                                                        <td>@lang('csv.bool_0')<br>@lang('csv.bool_1')</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>カラーID</th>
                                                        <td>color_id</td>
                                                        <td>数値を入力。商品の近似色から選択してください。
                                                            <ul>
                                                                <li><span style="color: #ffffff"><i class="fas fa-square"></i></span> 1:ホワイト系</li>
                                                                <li><span style="color: #000000"><i class="fas fa-square"></i></span> 2:ブラック系</li>
                                                                <li><span style="color: #808080"><i class="fas fa-square"></i></span> 3:グレー系</li>
                                                                <li><span style="color: #A52A2A"><i class="fas fa-square"></i></span> 4:ブラウン系</li>
                                                                <li><span style="color: #9a753a"><i class="fas fa-square"></i></span> 5:カーキ系</li>
                                                                <li><span style="color: #F5F5DC"><i class="fas fa-square"></i></span> 6:ベージュ系</li>
                                                                <li><span style="color: #00FF00"><i class="fas fa-square"></i></span> 7:ライム系</li>
                                                                <li><span style="color: #008000"><i class="fas fa-square"></i></span> 8:グリーン系</li>
                                                                <li><span style="color: #808000"><i class="fas fa-square"></i></span> 9:オリーブ系</li>
                                                                <li><span style="color: #0000FF"><i class="fas fa-square"></i></span> 10:ブルー系</li>
                                                                <li><span style="color: #000080"><i class="fas fa-square"></i></span> 11:ネイビー系</li>
                                                                <li><span style="color: #40E0D0"><i class="fas fa-square"></i></span> 12:ターコイズ系</li>
                                                                <li><span style="color: #E6E6FA"><i class="fas fa-square"></i></span> 13:ラベンダー系</li>
                                                                <li><span style="color: #800080"><i class="fas fa-square"></i></span> 14:パープル系</li>
                                                                <li><span style="color: #EE82EE"><i class="fas fa-square"></i></span> 15:バイオレット系</li>
                                                                <li><span style="color: #FF0000"><i class="fas fa-square"></i></span> 16:レッド系</li>
                                                                <li><span style="color: #FFC0CB"><i class="fas fa-square"></i></span> 17:ピンク系</li>
                                                                <li><span style="color: #FFA500"><i class="fas fa-square"></i></span> 18:オレンジ系</li>
                                                                <li><span style="color: #FFFF00"><i class="fas fa-square"></i></span> 19:イエロー系</li>
                                                                <li><span style="color: #FFD700"><i class="fas fa-square"></i></span> 20:ゴールド系</li>
                                                                <li><span style="color: #C0C0C0"><i class="fas fa-square"></i></span> 21:シルバー系</li>
                                                            </ul>
                                                        </td>
                                                        <td>@lang('csv.num')</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('item.color_name')</th>
                                                        <td>color_name</td>
                                                        <td>カラーの名称を入力</td>
                                                        <td>@lang('csv.string')(30)</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('item.size_name')</th>
                                                        <td>size_name</td>
                                                        <td>サイズの名称を入力。例：S、M、L、XL、F、38、40、24cm</td>
                                                        <td>@lang('csv.string')(10)</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.item.desc')</th>
                                                        <td>@lang('csv.item.description')</td>
                                                        <td>@lang('csv.item.description_exp')</td>
                                                        <td>@lang('csv.string')(10000)</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>サイズ詳細</th>
                                                        <td>size</td>
                                                        <td>商品サイズの詳細を入力してください。</td>
                                                        <td>@lang('csv.string')(10000)</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.item.tag_code')</th>
                                                        <td>@lang('csv.item.tag')</td>
                                                        <td>@lang('csv.item.tag_exp')</td>
                                                        <td>@lang('csv.string')(100)</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.item.group')</th>
                                                        <td>@lang('csv.item.group_code')</td>
                                                        <td>@lang('csv.item.group_code_exp')</td>
                                                        <td>@lang('csv.string')(40)</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.item.status')</th>
                                                        <td>@lang('csv.item.item_status')</td>
                                                        <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.item.item_status_exp')</td>
                                                        <td>@lang('csv.item.status0')<br>@lang('csv.item.status1')</td>
                                                        <td></td>
                                                    </tr>
                                                    @if( $company->maker_flag == 1 )
                                                    <tr>
                                                        <th>@lang('csv.item.g_flag')</th>
                                                        <td>@lang('csv.item.global_flag')</td>
                                                        <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.item.global_flag_exp')</td>
                                                        <td>@lang('csv.bool_0')<br>@lang('csv.bool_1')</td>
                                                        <td></td>
                                                    </tr>
                                                    @elseif( $company->maker_flag == 0 )
                                                    <tr>
                                                        <th>@lang('csv.item.g_flag')</th>
                                                        <td>@lang('csv.item.global_flag')</td>
                                                        <td><span class="text-danger">@lang('csv.required')</span><br>0を入力してください。</td>
                                                        <td>@lang('csv.bool_0')<br>@lang('csv.bool_1')</td>
                                                        <td></td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <th>@lang('csv.item.s_c_id')</th>
                                                        <td>@lang('csv.item.storemap_category_id')</td>
                                                        <td>@lang('csv.item.storemap_category_id_exp')<br>
                                                            <form method="get" action="{{ action('ItemCsvExportController@SMCTempFileDownload') }}" class="h-adr" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('get')
                                                                <button type="submit" class="btn btn-warning"><i class="fas fa-file-download"></i> 一覧をダウンロード</button>
                                                            </form>
                                                        </td>
                                                        <td>@lang('csv.num')</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.item.img1')</th>
                                                        <td>@lang('csv.item.item_img1')</td>
                                                        <td>@lang('csv.item.item_img_exp')</td>
                                                        <td>@lang('csv.img')</td>
                                                        <td>@lang('csv.img_note')</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.item.img2')</th>
                                                        <td>@lang('csv.item.item_img2')</td>
                                                        <td>@lang('csv.item.item_img_exp')</td>
                                                        <td>@lang('csv.img')</td>
                                                        <td>@lang('csv.img_note')</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.item.img3')</th>
                                                        <td>@lang('csv.item.item_img3')</td>
                                                        <td>@lang('csv.item.item_img_exp')</td>
                                                        <td>@lang('csv.img')</td>
                                                        <td>@lang('csv.img_note')</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.item.img4')</th>
                                                        <td>@lang('csv.item.item_img4')</td>
                                                        <td>@lang('csv.item.item_img_exp')</td>
                                                        <td>@lang('csv.img')</td>
                                                        <td>@lang('csv.img_note')</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.item.img5')</th>
                                                        <td>@lang('csv.item.item_img5')</td>
                                                        <td>@lang('csv.item.item_img_exp')</td>
                                                        <td>@lang('csv.img')</td>
                                                        <td>@lang('csv.img_note')</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.item.img6')</th>
                                                        <td>@lang('csv.item.item_img6')</td>
                                                        <td>@lang('csv.item.item_img_exp')</td>
                                                        <td>@lang('csv.img')</td>
                                                        <td>@lang('csv.img_note')</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.item.img7')</th>
                                                        <td>@lang('csv.item.item_img7')</td>
                                                        <td>@lang('csv.item.item_img_exp')</td>
                                                        <td>@lang('csv.img')</td>
                                                        <td>@lang('csv.img_note')</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.item.img8')</th>
                                                        <td>@lang('csv.item.item_img8')</td>
                                                        <td>@lang('csv.item.item_img_exp')</td>
                                                        <td>@lang('csv.img')</td>
                                                        <td>@lang('csv.img_note')</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.item.img9')</th>
                                                        <td>@lang('csv.item.item_img9')</td>
                                                        <td>@lang('csv.item.item_img_exp')</td>
                                                        <td>@lang('csv.im「')</td>
                                                        <td>@lang('csv.img_note')</td>
                                                    </tr>
                                                    <tr>
                                                        <th>@lang('csv.item.img10')</th>
                                                        <td>@lang('csv.item.item_img10')</td>
                                                        <td>@lang('csv.item.item_img_exp')</td>
                                                        <td>@lang('csv.img')</td>
                                                        <td>@lang('csv.img_note')</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </dd>
                                        <dt>4-6. 商品の削除</dt>
                                        <dd>[商品管理 > 商品一覧]をクリックすると現在登録頂いている商品の一覧が表示されます。一覧より削除ボタンをクリックすると商品の削除が可能です。削除には管理者権限が必要です。</dd>
                                        <dt>4-7. 商品一括管理</dt>
                                        <dd>[商品管理 > 商品一括管理]をクリックすると、csvファイルによる商品情報の一括編集及び登録が可能です。商品データの一括ダウンロードをクリックすると、現在登録中の商品一覧がcsvファイル形式で出力されます。商品データの一括更新より、参照ボタンを押してcsvファイルを選択し、アップロードボタンをクリックすることで一括編集が可能です。処理の結果は登録頂いているメールアドレス宛にメールで通知されます。csvファイルの各項目については、[4-5. 商品の編集及び登録の設定値]の値を参照してください。
                                        </dd>
                                    </dl>
                                </div>
                                <div class="tab-pane fade" id="list-stock" role="tabpanel" aria-labelledby="list-stock-list">
                                    <h3><b>5. 在庫・価格管理</b></h3>
                                    <hr>
                                    <dl class="paragraph-1">
                                        <dt>5-1. 在庫・価格管理について</dt>
                                        <dd>各店舗ごとに取扱の可否と、在庫数・販売価格の設定ができます。[商品管理 > 商品一覧]より、編集ボタンをクリックして、上部の青色のタブ「取扱店舗」「価格設定」「在庫設定」「店舗コメント」をクリックすると編集可能です。</dd>
                                        <dt>5-2. 取扱店舗</dt>
                                        <dd>[商品管理 > 商品一覧 > 商品情報]の「取扱店舗」タブをクリックすると表示されます。現在この商品を取り扱っているお店を設定できます。ONの文字が見える状態で、商品は正常に表示されます。「取扱店舗を更新」をクリックすると更新されます。
                                        </dd>
                                        <dt>5-3. 価格設定</dt>
                                        <dd>[商品管理 > 商品一覧 > 商品情報]の「価格設定」タブをクリックすると表示されます。この商品を取り扱っているお店での販売価格を個別で設定できます。
                                            <dl class="paragraph-2">
                                                <dt>5-3-1. 価格設定の設定値</dt>
                                                <dd>各項目については以下の設定値をご確認ください。
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>@lang('csv.name')</th>
                                                                <th>@lang('csv.explanation')</th>
                                                                <th class="text-nowrap">@lang('csv.limit')</th>
                                                                <th>@lang('csv.note')</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th>店舗名</th>
                                                                <td>価格設定を行う店舗名です</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <th>@lang('csv.manage.price_title')</th>
                                                                <td>通常価格・最低価格・最高価格 の中から選択してください。</td>
                                                                <td>選択制限<br>・通常価格<br>・最低価格<br>・最高価格</td>
                                                                <td>サイト上で以下のように表示<br>
                                                                    通常価格「●●●●円」<br>最低価格「～●●●●円」<br>最高価格「●●●●円～」</td>
                                                            </tr>
                                                            <tr>
                                                                <th>@lang('csv.manage.price_title')</th>
                                                                <td>@lang('csv.manage.price_exp')</td>
                                                                <td>@lang('csv.num')(10)</td>
                                                                <td>@lang('csv.manage.price_note')</td>
                                                            </tr>
                                                            <tr>
                                                                <th>@lang('csv.manage.value_title')</th>
                                                                <td>@lang('csv.manage.value_exp')</td>
                                                                <td>@lang('csv.num')(10)</td>
                                                                <td>@lang('csv.manage.value_note')</td>
                                                            </tr>
                                                            <tr>
                                                                <th>@lang('csv.manage.start_date_title')</th>
                                                                <td>@lang('csv.manage.start_date_exp')</td>
                                                                <td>@lang('csv.date_time')</td>
                                                                <td>@lang('csv.manage.start_date_note')</td>
                                                            </tr>
                                                            <tr>
                                                                <th>@lang('csv.manage.end_date_title')</th>
                                                                <td>@lang('csv.manage.end_date_exp')</td>
                                                                <td>@lang('csv.date_time')</td>
                                                                <td>@lang('csv.manage.end_date_note')</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </dd>
                                            </dl>
                                        </dd>
                                        <dt>5-4. 在庫設定</dt>
                                        <dd>[商品管理 > 商品一覧 > 商品情報]の「在庫設定」タブをクリックすると表示されます。この商品を取り扱っているお店での在庫数等を個別で設定できます。
                                            <dl class="paragraph-2">
                                                <dt>5-4-1. 在庫設定の設定値</dt>
                                                <dd>各項目については以下の設定値をご確認ください。
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>@lang('csv.name')</th>
                                                                <th>@lang('csv.explanation')</th>
                                                                <th class="text-nowrap">@lang('csv.limit')</th>
                                                                <th>@lang('csv.note')</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th>店舗名</th>
                                                                <td>在庫設定を行う店舗名です</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <th>@lang('csv.manage.stock_set_title')</th>
                                                                <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.manage.stock_set_exp')</td>
                                                                <td>選択制限<br>・しない<br>・する</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <th>@lang('csv.manage.sort_num_title')</th>
                                                                <td>@lang('csv.manage.sort_num_exp')</td>
                                                                <td>@lang('csv.num')(10)</td>
                                                                <td>@lang('csv.manage.sort_num_note')</td>
                                                            </tr>
                                                            <tr>
                                                                <th>@lang('csv.manage.stock_amount_title')</th>
                                                                <td>@lang('csv.manage.stock_amount_exp')</td>
                                                                <td>@lang('csv.num')(8)</td>
                                                                <td>@lang('csv.manage.stock_amount_note')</td>
                                                            </tr>

                                                            <tr>
                                                                <th>@lang('csv.manage.shelf_number_title')</th>
                                                                <td>@lang('csv.manage.shelf_number_exp')</td>
                                                                <td>@lang('csv.string')(10)</td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </dd>
                                            </dl>
                                        </dd>
                                        <dt>5-5. 店舗コメント</dt>
                                        <dd>[商品管理 > 商品一覧 > 商品情報]の「店舗コメント」タブをクリックすると表示されます。この商品に関するコメントを店舗別に設定できます。
                                            <dl class="paragraph-2">
                                                <dt>5-5-1. 店舗コメントの設定値</dt>
                                                <dd>各項目については以下の設定値をご確認ください。
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>@lang('csv.name')</th>
                                                                <th>@lang('csv.explanation')</th>
                                                                <th class="text-nowrap">@lang('csv.limit')</th>
                                                                <th>@lang('csv.note')</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th>店舗名</th>
                                                                <td>在庫設定を行う店舗名です</td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <th>@lang('csv.manage.catch_copy_title')</th>
                                                                <td>@lang('csv.manage.catch_copy_exp')</td>
                                                                <td>@lang('csv.string')(140)</td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </dd>
                                            </dl>
                                        </dd>
                                        <dt>5-6. 販売情報一括管理</dt>
                                        <dd>[商品管理 > 販売情報一括管理]をクリックすることで、csvファイルによる販売店・在庫・価格・セール情報・棚番号・店舗コメント等の一括編集が可能です。販売管理マスタの一括ダウンロードをクリックすることで編集用のcsvファイルが出力されます。販売管理マスタの一括更新より、参照ボタンをクリックしてcsvファイルを選択し、アップロードボタンをクリックすることで一括編集が可能です。処理の結果は登録頂いているメールアドレス宛にメールで通知されます。csvファイルの各項目については、下記の値を参照してください。
                                            <dl class="paragraph-2">
                                                <dt>5-6-1. 販売情報一括管理の設定値</dt>
                                                <dd>csvの各項目については以下の設定値をご確認ください。
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>@lang('csv.name')</th>
                                                                <th>@lang('csv.csv_name')</th>
                                                                <th>@lang('csv.explanation')</th>
                                                                <th class="text-nowrap">@lang('csv.limit')</th>
                                                                <th>@lang('csv.note')</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th>@lang('csv.item.code')</th>
                                                                <td>@lang('csv.item.product_code')</td>
                                                                <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.manage.product_code_exp')</td>
                                                                <td>@lang('csv.string')(40)</td>
                                                                <td>@lang('csv.item.code_note')</td>
                                                            </tr>
                                                            <tr>
                                                                <th>@lang('csv.store.code')</th>
                                                                <td>@lang('csv.store.store_code')</td>
                                                                <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.manage.store_code_exp')</td>
                                                                <td>@lang('csv.string')(20)</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <th>@lang('csv.manage.p_type')</th>
                                                                <td>@lang('csv.manage.price_type')</td>
                                                                <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.manage.price_type_exp')</td>
                                                                <td>@lang('csv.manage.price_type_0')<br>@lang('csv.manage.price_type_1')<br>@lang('csv.manage.price_type_2')</td>
                                                                <td>@lang('csv.manage.price_type_note')</td>
                                                            </tr>
                                                            <tr>
                                                                <th>@lang('csv.manage.price_title')</th>
                                                                <td>@lang('csv.manage.price')</td>
                                                                <td>@lang('csv.manage.price_exp')</td>
                                                                <td>@lang('csv.num')(10)</td>
                                                                <td>@lang('csv.manage.price_note')</td>
                                                            </tr>
                                                            <tr>
                                                                <th>@lang('csv.manage.value_title')</th>
                                                                <td>@lang('csv.manage.value')</td>
                                                                <td>@lang('csv.manage.value_exp')</td>
                                                                <td>@lang('csv.num')(10)</td>
                                                                <td>@lang('csv.manage.value_note')</td>
                                                            </tr>
                                                            <tr>
                                                                <th>@lang('csv.manage.start_date_title')</th>
                                                                <td>@lang('csv.manage.start_date')</td>
                                                                <td>@lang('csv.manage.start_date_exp')</td>
                                                                <td>@lang('csv.date_time')</td>
                                                                <td>@lang('csv.manage.start_date_note')</td>
                                                            </tr>
                                                            <tr>
                                                                <th>@lang('csv.manage.end_date_title')</th>
                                                                <td>@lang('csv.manage.end_date')</td>
                                                                <td>@lang('csv.manage.end_date_exp')</td>
                                                                <td>@lang('csv.date_time')</td>
                                                                <td>@lang('csv.manage.end_date_note')</td>
                                                            </tr>
                                                            <tr>
                                                                <th>@lang('csv.manage.sort_num_title')</th>
                                                                <td>@lang('csv.manage.sort_num')</td>
                                                                <td>@lang('csv.manage.sort_num_exp')</td>
                                                                <td>@lang('csv.num')(10)</td>
                                                                <td>@lang('csv.manage.sort_num_note')</td>
                                                            </tr>
                                                            <tr>
                                                                <th>@lang('csv.manage.stock_amount_title')</th>
                                                                <td>@lang('csv.manage.stock_amount')</td>
                                                                <td>@lang('csv.manage.stock_amount_exp')</td>
                                                                <td>@lang('csv.num')(8)</td>
                                                                <td>@lang('csv.manage.stock_amount_note')</td>
                                                            </tr>
                                                            <tr>
                                                                <th>@lang('csv.manage.stock_set_title')</th>
                                                                <td>@lang('csv.manage.stock_set')</td>
                                                                <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.manage.stock_set_exp')</td>
                                                                <td>@lang('csv.manage.stock_set0')<br>@lang('csv.manage.stock_set1')</td>
                                                                <td>@lang('csv.manage.stock_set_note')</td>
                                                            </tr>
                                                            <tr>
                                                                <th>@lang('csv.manage.catch_copy_title')</th>
                                                                <td>@lang('csv.manage.catch_copy')</td>
                                                                <td>@lang('csv.manage.catch_copy_exp')</td>
                                                                <td>@lang('csv.string')(140)</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <th>@lang('csv.manage.shelf_number_title')</th>
                                                                <td>@lang('csv.manage.shelf_number')</td>
                                                                <td>@lang('csv.manage.shelf_number_exp')</td>
                                                                <td>@lang('csv.string')(10)</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <th>@lang('csv.manage.selling_flag_title')</th>
                                                                <td>@lang('csv.manage.selling_flag')</td>
                                                                <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.manage.selling_flag_exp')</td>
                                                                <td>@lang('csv.manage.selling_flag0')<br>@lang('csv.manage.selling_flag1')</td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </dd>
                                            </dl>
                                        </dd>
                                    </dl>
                                </div>
                                <div class="tab-pane fade" id="list-images" role="tabpanel" aria-labelledby="list-images-list">
                                    <h3><b>6. 画像管理</b></h3>
                                    <hr>
                                    <dl class="paragraph-1">
                                        <dt>6-1. 画像管理について</dt>
                                        <dd>画像管理には、商品ページ用の画像を管理する「商品画像管理」と、店舗用の画像を管理する「店舗画像管理」の２種類があります。</dd>
                                        <dt>6-2. 商品画像管理</dt>
                                        <dd>[画像管理 > 商品画像管理]をクリックすると、商品ページ用の画像を登録・削除するための画像管理ページが開きます。</dd>
                                        <dt>6-3. 店舗画像管理</dt>
                                        <dd>[画像管理 > 店舗画像管理]をクリックすると、店舗ページ用の画像を登録・削除するための店舗管理ページが開きます。</dd>
                                        <dt>6-4. 画像の登録</dt>
                                        <dd>商品画像管理、又は、店舗画像管理のページを開いた状態で、「画像を追加する」ボタンをクリックします。<br>
                                            別窓がポップアップで表示されるので、枠内に登録したい画像をドラッグ＆ドロップしてください。複数枚まとめての登録も可能です。<br>
                                            登録が完了すると「アップロードが完了しました」のポップアップが表示されます。
                                        </dd>
                                        <dt>6-5. 画像登録時の注意事項</dt>
                                        <dd>画像登録時の注意事項です。
                                            <ul>
                                                <li>登録される画像の縦と横の最大長は750pxです。この長さを超える画像を登録した場合は、長辺を750pxとして比率を保ったまま自動でリサイズされます。</li>
                                                <li>同じファイル名の画像がある場合は上書きされます。</li>
                                                <li>日本語や全角文字を含むファイル名は、自動で半角ファイル名へリネームされます。</li>
                                                <li>1度にアップできる画像は500枚までです。</li>
                                                <li>利用できる画像の最大容量は、ご契約頂いているプランごとに違います。商品画像と店舗画像をあわせて「ライトプラン：100Mbyteまで」「ベーシックプラン：10GByteまで」「プレミアムプラン：50GByteまで」となります。</li>
                                            </ul>
                                        </dd>
                                        <dt>6-6. 画像の削除</dt>
                                        <dd>商品画像管理、又は、店舗画像管理のページを開いた状態で、削除したい画像の右側にあるゴミ箱アイコンの横のチェックボックスにチェックを入れます。その後「チェックを削除」をクリックすることで削除可能です。複数の画像にチェックを入れることで、まとめての削除も可能です。</dd>
                                    </dl>
                                </div>
                                <div class="tab-pane fade" id="list-catalog" role="tabpanel" aria-labelledby="list-catalog-list">
                                    <h3><b>7. カタログ出品</b></h3>
                                    <hr>
                                    <dl class="paragraph-1">
                                        <dt>7-1. カタログ出品について</dt>
                                        <dd>メーカーが作成した商品データを元に、商品情報をコピーして出品できる仕組みです。JANコード・商品名・商品コードのいずれかから検索可能です。またcsvによるコピーも可能です。</dd>
                                        <dt>7-2. 出品方法</dt>
                                        <dd>[カタログ > カタログ出品]をクリックします。カタログ出品の画面が表示されたら、JANコード・商品名・商品コードのいずれかで検索します。検索結果に該当する商品があった場合は「詳細」をクリックします。詳細で内容を確認したあと、「商品情報をコピーして出品する」をクリックすると、商品情報がコピーされます。
                                        </dd>
                                        <dt>7-3. カタログ一括出品</dt>
                                        <dd>[カタログ > カタログ一括出品]をクリックすることで、csvを利用した商品情報の一括コピーが可能です。コピー元の商品が見つからない場合は、登録されずスキップします。</dd>
                                        <dt>7-4. カタログ一括出品の設定値</dt>
                                        <dd>csvの各項目については以下の設定値をご確認ください。
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>@lang('csv.name')</th>
                                                        <th>@lang('csv.csv_name')</th>
                                                        <th>@lang('csv.explanation')</th>
                                                        <th class="text-nowrap">@lang('csv.limit')</th>
                                                        <th>@lang('csv.note')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>@lang('csv.catalog.barcode_title')</th>
                                                        <td>@lang('csv.catalog.barcode')</td>
                                                        <td><span class="text-danger">@lang('csv.required')</span><br>@lang('csv.catalog.barcode_exp')</td>
                                                        <td>@lang('csv.string')(20)</td>
                                                        <td>@lang('csv.catalog.barcode_note')</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </dd>
                                    </dl>
                                </div>
                                <div class="tab-pane fade" id="list-users" role="tabpanel" aria-labelledby="list-users-list">
                                    <h3><b>8. 担当者管理</b></h3>
                                    <hr>
                                    <dl class="paragraph-1">
                                        <dt>8-1. 担当者管理について</dt>
                                        <dd>担当者管理では管理ユーザーの追加や削除と、担当者の権限変更、担当店舗の設定が可能です。</dd>
                                        <dt>8-2. 担当者の追加</dt>
                                        <dd>[担当者管理 > 担当者登録]をクリックすると、担当者を追加登録するためのページが開きます。ユーザー名とメールアドレス、パスワード、管理権限を選択して、「ユーザー追加のための確認メールを送信」をクリックすることで、入力したメールアドレスに認証メールが届きます。</dd>
                                        <dt>8-3. 担当者の編集</dt>
                                        <dd>[担当者管理 > 担当者一覧]をクリックすると、担当者の一覧が表示されます。「編集」ボタンをクリックすることで、該当ユーザーの情報を変更することができます。
                                            <dl class="paragraph-2">
                                                <dt>8-3-1. ユーザー名の変更</dt>
                                                <dd>ユーザー名の値を変更することで、ユーザー名を変更できます。
                                                </dd>
                                                <dt>8-3-2. 管理権限の変更</dt>
                                                <dd>管理権限の値を変更することで、「管理者」か「担当者」を選ぶことができます。尚、自分の権限を変更することはできません。
                                                </dd>
                                                <dt>8-3-3. 担当店舗の設定</dt>
                                                <dd>店舗を複数運営しているときは、ユーザーごとに担当店舗の変更が可能です。担当店舗に設定することで、店舗の在庫や価格を変更できるようになります。
                                                </dd>
                                            </dl>
                                        </dd>
                                        <dt>8-4. 管理権限について</dt>
                                        <dd>以下の２種類の管理権限があります。
                                            <ul>
                                                <li>管理者</li>
                                                <li>担当者</li>
                                            </ul>・
                                            管理者と担当者の違いについては以下を参照してください。
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>項目名</th>
                                                        <th>管理者</th>
                                                        <th>担当者</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>店舗の閲覧</th>
                                                        <td><i class="far fa-circle"></i></td>
                                                        <td><i class="far fa-circle"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <th>店舗の追加・編集・削除</th>
                                                        <td><i class="far fa-circle"></i></td>
                                                        <td><i class="fas fa-times"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <th>店舗カレンダーの編集</th>
                                                        <td><i class="far fa-circle"></i></td>
                                                        <td><i class="far fa-circle"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <th>商品の追加・編集・削除</th>
                                                        <td><i class="far fa-circle"></i></td>
                                                        <td><i class="far fa-circle"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <th>カテゴリの登録</th>
                                                        <td><i class="far fa-circle"></i></td>
                                                        <td><i class="far fa-circle"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <th>カテゴリの編集・削除</th>
                                                        <td><i class="far fa-circle"></i></td>
                                                        <td><i class="fas fa-times"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <th>担当者の閲覧</th>
                                                        <td><i class="far fa-circle"></i></td>
                                                        <td><i class="far fa-circle"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <th>担当者の追加・編集・削除</th>
                                                        <td><i class="far fa-circle"></i></td>
                                                        <td><i class="fas fa-times"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <th>担当店舗の変更</th>
                                                        <td><i class="far fa-circle"></i></td>
                                                        <td><i class="fas fa-times"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <th>画像の追加・削除</th>
                                                        <td><i class="far fa-circle"></i></td>
                                                        <td><i class="far fa-circle"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <th>APIの設定</th>
                                                        <td><i class="far fa-circle"></i></td>
                                                        <td><i class="fas fa-times"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <th>お支払い情報の閲覧・変更</th>
                                                        <td><i class="far fa-circle"></i></td>
                                                        <td><i class="fas fa-times"></i></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </dd>
                                        <dt>8-5. 担当者の削除</dt>
                                        <dd>[担当者管理 > 担当者一覧]をクリック後、一覧より削除したいユーザーの横にある「削除」をクリックすることで、該当ユーザーの削除が可能です。
                                        </dd>
                                    </dl>
                                </div>
                                <div class="tab-pane fade" id="list-api" role="tabpanel" aria-labelledby="list-api-list">
                                    <h3><b>9. API設定</b></h3>
                                    <hr>
                                    <dl class="paragraph-1">
                                        <dt>9-1. API設定について</dt>
                                        <dd>弊社サーバーへリクエストを送信することで、ご利用中の在庫管理システムやPOSレジと在庫や価格の連動が可能になります。
                                        </dd>
                                        <dt>9-2. 利用可能なAPI</dt>
                                        <dd>現在ご利用いただけるのは以下になります。
                                            <ul>
                                                <li>汎用API</li>
                                                <li>スマレジAPI</li>
                                            </ul>
                                        </dd>
                                        <dt>9-3. 汎用APIの設定</dt>
                                        <dd>[設定 > API設定 > 受信用API]をクリックすることで、汎用APIの設定を行うことができます。
                                            <dl class="paragraph-2">
                                                <dt>9-3-1. 受信設定</dt>
                                                <dd>受信設定欄にある「アクセストークン作成」をクリックすると、アクセストークンが作成されます。また受信機能を利用するの設定で、「利用する」を選択することで、受信APIが利用可能になります。
                                                </dd>
                                                <dt>9-3-2. 在庫の更新</dt>
                                                <dd>在庫情報送信先URLに記載のあるURLに、仕様に従ったリクエストを送信して頂くことで在庫の更新が可能です。
                                                </dd>
                                                <dt>9-3-3. 商品情報の更新</dt>
                                                <dd>商品情報送信先URLに記載のあるURLに、仕様に従ったリクエストを送信して頂くことで商品情報の更新が可能です。販売価格・セール価格・開始日時・終了日時・表示設定の変更が可能です。
                                                </dd>
                                                <dt>9-3-4.汎用APIの仕様について</dt>
                                                <dd>[設定 > API設定 > 受信用API]にある受信用APIの設定について欄に詳細の記載がございますので、そちらをご確認ください。
                                                </dd>
                                            </dl>
                                        </dd>
                                        <dt>9-4. スマレジAPI連携</dt>
                                        <dd>[設定 > API設定 > スマレジAPI連携]をクリックすることで、スマレジAPIとの連携設定を行うことができます。
                                            <dl class="paragraph-2">
                                                <dt>9-4-1.連携設定</dt>
                                                <dd>スマレジAPIと連携するために、契約IDとアクセストークンが必要になります。アクセストークンは、[設定 > API設定 > 受信用API]から作成できます。
                                                </dd>
                                                <dt>9-4-2.連携店舗の準備</dt>
                                                <dd>
                                                    店舗コードをスマレジ側と同じにする必要があります。
                                                    <ul>
                                                        <li>連携したい店舗の店舗コードをスマレジと同じにする必要があります。ストアマップの[店舗管理 > 店舗一覧] に記載のある店舗コードと、スマレジ側の[店舗 > 店舗一覧] に記載のある店舗コードを同じにする必要があります。違う場合はストアマップの[店舗管理 > 店舗一覧 > 詳細 > 店舗情報を編集する] と進み、店舗コードを修正してください。</li>
                                                    </ul>
                                                </dd>
                                                <dt>9-4-3.スマレジ側設定</dt>
                                                <dd>
                                                    <ul>
                                                        <li class="mb-3">スマレジ側の管理画面を開いて、[設定 > システム連携 > スマレジAPI設定]をクリックします。
                                                            <div><img src="{{asset('img/smareji/srejiapi-1.gif')}}" style="max-width:100%;"></div>
                                                        </li>
                                                        <li class="mb-3">スマレジAPI設定画面内の、API送信設定ボタンをクリックして、送信機能を利用するを選択します。
                                                            <div><img src="{{asset('img/smareji/srejiapi-2.gif')}}" style="max-width:100%;"></div>
                                                        </li>
                                                        <li class="mb-3">画面を下にスクロールして、商品情報送信と、在庫情報送信を利用するにチェックを入れて個別設定をクリックします。
                                                            <div><img src="{{asset('img/smareji/srejiapi-3.gif')}}" style="max-width:100%;"></div>
                                                        </li>
                                                        <li class="mb-3">商品情報送信では、送信URLに「https://storemap.jp/api/sregi/receive_item」を入力。ヘッダ情報に[設定 > API設定 > 受信用API]で作成したアクセストークンと、契約IDを入力してください。
                                                            <div><img src="{{asset('img/smareji/srejiapi-4.gif')}}" style="max-width:100%;"></div>
                                                        </li>
                                                        <li class="mb-3">在庫情報送信では、送信URLに「https://storemap.jp/api/sregi/receive_stock」を入力。ヘッダ情報に[設定 > API設定 > 受信用API]で作成したアクセストークンと、契約IDを入力してください。
                                                            <div><img src="{{asset('img/smareji/srejiapi-5.gif')}}" style="max-width:100%;"></div>
                                                        </li>
                                                    </ul>
                                                    最後に更新ボタンをクリックしてください。
                                                </dd>
                                                <dt>9-4-4. 商品連携用CSVのアップロード</dt>
                                                <dd>スマレジの商品IDをストアマップのデータベースに登録する必要があります。ストアマップの商品コードを、スマレジ商品IDを入力したcsvをアップロードしてください。
                                                    <ul>
                                                        <li class="mb-3">スマレジ側の管理画面を開いて、[商品 > 商品一覧 > CSVダウンロード]をクリックして、csvをダウンロードします。
                                                            <div><img src="{{asset('img/smareji/srejiapi-6.gif')}}" style="max-width:100%;"></div>
                                                        </li>
                                                        <li class="mb-3">ストアマップの管理画面を開いて、[設定 > システム連携 > スマレジAPI設定]をクリック後、登録用テンプレートファイル欄にある「テンプレートファイルをダウンロード」をクリックしてcsvファイルをダウンロードしてください。
                                                        </li>
                                                        <li class="mb-3">ストアマップ側でダウンロードしたファイルのbarcode欄と、スマレジ側でダウンロードしたファイルの商品コード欄を照らし合わせて、ストアマップ側のcsvファイルのext_product_code欄に、スマレジ側の商品IDの値を入力してください。
                                                        </li>
                                                        <li class="mb-3">入力が完了したら保存して、商品連携用CSVのアップロードより、アップロードしてください。
                                                        </li>
                                                    </ul>
                                                    以上の項目が設定できれば、連携が始まります。
                                                </dd>
                                            </dl>
                                        </dd>
                                    </dl>
                                </div>
                                <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
                                    <h3><b>10. 各種設定</b></h3>
                                    <hr>
                                    <dl class="paragraph-1">
                                        <dt>10-1. 会社情報の変更</dt>
                                        <dd>[設定 > 会社情報]をクリックすることで、現在登録中の会社情報を閲覧することができます。会社情報を編集するをクリックすることで、登録済みの会社情報を変更することができます。</dd>
                                        <dt>10-2. パスワード変更</dt>
                                        <dd>[設定 > パスワード変更]をクリックすることで、ログイン時のパスワードを変更することが出来ます。現在のパスワードを入力後、新しいパスワードを入力してください。</dd>
                                        <dt>10-3. API設定</dt>
                                        <dd>[設定 > API設定]をクリックすることで、API設定の変更や情報の閲覧が可能です。詳しくは[9. API設定]をご覧ください。</dd>
                                        <dt>10-4. お支払い情報の変更</dt>
                                        <dd>[設定 > お支払い情報]をクリックすることでより、現在の支払い方法の変更や、お支払い情報の確認が出来ます。詳しくは[11. ご契約について]をご覧ください。</dd>
                                    </dl>
                                </div>
                                <div class="tab-pane fade" id="list-contract" role="tabpanel" aria-labelledby="list-contract-list">
                                <h3><b>11. ご契約について</b></h3>
                                    <hr>
                                    <dl class="paragraph-1">
                                        <dt>11-1. ご契約について</dt>
                                        <dd>[設定 > お支払い情報]をクリックすることでより、現在の支払い方法の変更や、お支払い情報の確認、契約の解除が出来ます。決済にStripeのオンライン決済を利用しております。ご登録頂いカード番号などの情報は弊社では保存しておりません。</dd>
                                        <dt>11-2. ご請求金額の確認</dt>
                                        <dd>ご請求金額については、画面右下の「現在のご請求金額」をご覧ください。合計(税込)欄にある金額が次回ご請求金額となります。下に無料期間の記載がある場合、その期間中はご請求されません。</dd>
                                        <dt>11-3. 契約内容の変更</dt>
                                        <dd>契約内容を変更した場合は、画面左下よりご変更ください。ご契約プランと、登録可能店舗数の変更が可能です。契約内容を変更した場合のお見積金額は画面右下に表示されますのでご確認ください。確認後、「プランを変更する」ボタンをクリックすることで変更が可能です。</dd>
                                        <dt>11-4. カード情報の変更</dt>
                                        <dd>お支払いにご利用頂いているカードの有効期限が切れた場合など、ご変更頂く場合は、「お支払いカード情報の変更」欄より、新しいカード名義人名とカード情報を入力してください。またカード番号欄右側には、有効期限とCVC(セキュリティーコード)の入力欄もあります。</dd>
                                        <dt>11-5. 契約の解除</dt>
                                        <dd>画面左下「契約のキャンセル」より、「キャンセルする」ボタンをクリックして頂くことで、お支払いのキャンセルが可能です。画面の表記が「キャンセル済みです」と表示されていればキャンセル処理が完了しています。「元に戻す」ボタンをクリックすると、解除前と同じ契約状態に戻ります。</dd>
                                    </dl>
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
            <h5></h5>
            <hr class="mb-2">
            <p></p>
            <p>カテゴリの削除は管理者ユーザーのみが利用可能です。管理権限の設定は、担当者管理＞担当者一覧より設定できます。</p>
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
<style>
    .accordion .card {
        margin-bottom: 0;
    }

    .paragraph-1 dd {
        margin-bottom: 1.5rem;
    }

    .paragraph-2 {
        margin-top: .5rem;
        margin-left: 1rem;
    }

    .paragraph-2 dd {
        margin-bottom: 1.5rem;
    }
</style>
@stop

@section('js')

@stop
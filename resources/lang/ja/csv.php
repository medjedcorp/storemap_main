<?php

return [
  'download'     => 'ダウンロード',
  'upload'     => 'アップロード',
  'name'     => '項目名',
  'csv_name'  => 'CSV項目名',
  'explanation'  => '説明',
  'limit'     => '入力制限',
  'note'     => '補足',
  'required'     => '※必須項目',
  'string'     => '文字',
  'jpzip'     => '半角英数記号(8)',
  'tel'     => '数値記号(20)',
  'email'     => '半角英数記号(255)',
  'img'     => '半角英数記号(100)',
  'num'     => '数値',
  'integer'     => '整数型',
  'integer_note'     => '数値のみ小数点不可',
  'url'     => '半角英数記号(255)',
  'bool_0'     => '0：非公開',
  'bool_1'     => '1：公開',
  'date_time'     => 'Y/M/D H:M形式',
  'template'     => 'テンプレートファイルをダウンロード',
  'li1'     => 'CSVの項目名はアンダーバーも含め、全て半角です。',
  'li2'     => '入力制限欄の(○○)は文字数制限です。半角・全角関係なく1文字ずつカウントします。',
  'li3'     => '入力制限欄の「数値(X.Y)」のXは「整数の桁数」 Yは「小数点以下の桁数」を表しています。',
  'li4'     => '例えば「数値(3.2)」と記載してある場合、入力する値の一例は「123.12」です。',
  'li5'     => '文字コードは(Shift-JIS)を選択してください。',
  'img_note'     => '画像形式はjpg,jpeg,png,gifのみ',
  'upload_label'     => 'csvファイルを選択',
  'upload_small'     => '※ヘッダー行は取り込まれません。アップロードの結果はメールでお知らせします',
  'upload_size'     => '※一度にアップロードできるファイルサイズは10Mまでです',
  'category' => [
    'card_title'     => 'カテゴリマスタのcsv項目名とルール',
    'code'     => 'カテゴリコード',
    'category_code'     => 'category_code',
    'code_exp'     => '商品が所属する部門やカテゴリのコードを入力',
    'code_note'     => '半角英数と半角ハイフンのみ使用可能です。',
    'name'     => 'カテゴリ名',
    'category_name'     => 'category_name',
    'category_exp'     => '商品が所属する部門やカテゴリの名称を入力	',
    'flag'     => '表示設定	',
    'display_flag'     => 'display_flag',
    'display_exp'     => 'カテゴリを表示するか、しないかを設定。非公開にした場合は所属する商品がすべて非公開になります',
  ],
  'store' => [
    'card_title'     => '店舗マスタのcsv項目名とルール',
    'code'     => '店舗コード',
    'store_code'     => 'store_code',
    'code_exp'     => '店舗のコードを入力',
    'code_note'     => '半角英数のみ使用可能です。',
    'name'     => '店舗名',
    'store_name'     => 'store_name',
    'store_name_exp'     => '商品が所属する部門やカテゴリの名称を入力',
    'postcode'     => '店舗郵便番号',
    'store_postcode'     => 'store_postcode',
    'store_postcode_exp'     => '郵便番号を入力',
    'store_postcode_note'     => '例:000-0000(ハイフンありで入力)',
    'kana'     => '店舗名かな',
    'store_kana'     => 'store_kana',
    'store_kana_exp'     => '店舗名をひらがなで入力',
    'pre'     => '都道府県',
    'prefecture'     => 'prefecture',
    'prefecture_exp'     => '店舗住所の都道府県を入力',
    'prefecture_note'     => '例：東京都 (都道府県まで付与。東京のみだとエラーになります)',
    'city'     => '市区町村',
    'store_city'     => 'store_city',
    'store_city_exp'     => '店舗住所の市区町村を入力',
    'adnum'     => '町名・番地',
    'store_adnum'     => 'store_adnum',
    'store_adnum_exp'     => '店舗住所の町名・番地を入力',
    'apart'     => 'ビル、マンション名',
    'store_apart'     => 'store_apart',
    'store_apart_exp'     => '店舗住所のビル、マンション名等を入力',
    'phone_number'     => '店舗電話番号',
    'store_phone_number'     => 'store_phone_number',
    'store_phone_number_exp'     => '店舗住所の電話番号を入力',
    'store_phone_number_note'     => '例:00-0000-0000(ハイフンありで入力)',
    'fax_number'     => '店舗FAX番号',
    'store_fax_number'     => 'store_fax_number',
    'store_fax_number_exp'     => '店舗住所のFAX番号を入力',
    'store_fax_number_note'     => '例:00-0000-0000(ハイフンありで入力)',
    'email'     => '店舗メールアドレス',
    'store_email'     => 'store_email',
    'store_email_exp'     => '店舗のメールアドレスを入力',
    'flag'     => '休止フラグ',
    'pause_flag'     => 'pause_flag',
    'pause_flag_exp'  => '店舗を表示するか、しないかを設定。非公開にした場合は店舗情報が表示されなくなります',
    'pause_flag_note'  => '0または1を入力',
    'img1'     => '店舗画像1枚目',
    'store_img1'     => 'store_img1',
    'img2'     => '店舗画像2枚目',
    'store_img2'     => 'store_img2',
    'img3'     => '店舗画像3枚目',
    'store_img3'     => 'store_img3',
    'img4'     => '店舗画像4枚目',
    'store_img4'     => 'store_img4',
    'img5'     => '店舗画像5枚目',
    'store_img5'     => 'store_img5',
    'store_img_exp'     => '店舗画像管理にアップした、画像のファイル名を指定',
    'info'     => '店舗お知らせ',
    'store_info'     => 'store_info',
    'pay_info'     => 'pay_info',
    'access'     => 'access',
    'opening_hour'     => 'opening_hour',
    'closed_day'     => 'closed_day',
    'parking'     => 'parking',
    'store_info_exp'     => '店舗からのお知らせや紹介文を入力',
    'pay_info_exp'     => '店舗で使える決済情報を入力',
    'access_exp'     => '店舗への道順などアクセス方法を入力',
    'opening_hour_exp'     => '営業時間を入力',
    'closed_day_exp'     => '定休日を入力',
    'parking_exp'     => '店舗の駐車場について入力',
    'industry'     => '業種ID',
    'industry_id'     => 'industry_id',
    'industry_id_exp'     => '店舗の業種IDを指定',
    'industry_id_note'     => '0：飲食店、1：アパレル、2：食料品、3：医薬品・化粧品、4：本、5：家電、6：工具・DIY、7：ペット、8：雑貨、9：イベント物販、10：総合小売店、11：その他小売、12：医療、13：宿泊、14：理容・美容、15：エステ・ネイル・マッサージ、16：運動、17：教育、18：不動産、19：金融保険、20：建築、21：自動車・バイク、22：運輸、23：娯楽、24：通信、25：写真、26：冠婚葬祭、27：旅行、28：リサイクル、29:美術館・博物館、30:動物園、水族館、31:遊園地、32:寺社仏閣',
    'url'     => '店舗サイトURL',
    'store_url'     => 'store_url',
    'store_url_exp'     => '店舗のURLを入力',
    'flyer'     => 'チラシ画像URL',
    'flyer_img'     => 'flyer_img',
    'flyer_img'     => 'チラシ画像のURLを入力',
    'floor'     => '店舗内見取り図',
    'floor_guide'     => 'floor_guide',
    'floor_guide_exp'     => '店舗内見取図の画像URLを入力',
  ],
  'item' => [
    'card_title'     => '商品マスタのcsv項目名とルール',
    'code'     => '商品コード',
    'product_code'     => 'product_code',
    'code_exp'     => '商品のコードを入力',
    'code_note'     => '半角英数と半角ハイフンのみ使用可能',
    'name'     => '商品名',
    'product_name'     => 'product_name',
    'product_name_exp'     => '商品の名称を入力',
    'brand'     => 'ブランド名',
    'brand_name'     => 'brand_name',
    'brand_exp'     => 'ブランド名を入力	',
    'bar'     => 'JANコード',
    'barcode'     => 'barcode',
    'barcode_exp'     => '商品のJANコードやバーコードを入力',
    'barcode_note'     => '半角英数のみ使用可能',
    'o_price'     => '定価',
    'original_price'     => 'original_price',
    'original_price_exp'     => '商品の定価を入力。入力のない場合はオープン価格となります',
    'original_price_note'     => '数値のみ使用可能',
    'flag'     => '表示設定	',
    'display_flag'     => 'display_flag',
    'display_flag_exp'     => '商品を表示するか、しないかを設定',
    'desc'     => '商品説明',
    'description'     => 'description',
    'description_exp'     => '商品の説明を入力',
    'tag_code'     => 'タグ',
    'tag'     => 'tag',
    'tag_exp'     => '商品の検索補助キーワードがあれば入力',
    'group'     => 'グループコード',
    'group_code'     => 'group_code',
    'group_code_exp'     => '同じ分類に属する商品が他にある場合(色違いやサイズ違いなど)、グループコードを入力することで同じグループに属する商品であることを設定できます',
    'status'     => '商品状態',
    'item_status'     => 'item_status',
    'status0'     => '0：中古',
    'status1'     => '1：新品',
    'item_status_exp'     => '商品が中古か、新品かを設定できます',
    'g_flag'     => 'カタログ登録',
    'global_flag'     => 'global_flag',
    'global_flag_exp'     => 'カタログに公開「する」か「しない」かを設定できます。会社情報でメーカー設定をしていない場合は、1を入力しても0で登録されます',
    'global_flag_note'     => 'カタログ機能に登録することで、取扱店が商品情報を参照し、簡単に商品登録ができるため販路拡大に繋がります',
    's_c_id'     => 'ストアマップカテゴリID',
    'storemap_category_id'     => 'storemap_category_id',
    'storemap_category_id_exp'     => '当サイト上でのカテゴリをIDで指定できます。当サイトに表示されるカテゴリに登録することができます',
    'img1'     => '商品画像1枚目',
    'item_img1'     => 'item_img1',
    'img2'     => '商品画像2枚目',
    'item_img2'     => 'item_img2',
    'img3'     => '商品画像3枚目',
    'item_img3'     => 'item_img3',
    'img4'     => '商品画像4枚目',
    'item_img4'     => 'item_img4',
    'img5'     => '商品画像5枚目',
    'item_img5'     => 'item_img5',
    'img6'     => '商品画像6枚目',
    'item_img6'     => 'item_img6',
    'img7'     => '商品画像7枚目',
    'item_img7'     => 'item_img7',
    'img8'     => '商品画像8枚目',
    'item_img8'     => 'item_img8',
    'img9'     => '商品画像9枚目',
    'item_img9'     => 'item_img9',
    'img10'     => '商品画像10枚目',
    'item_img10'     => 'item_img10',
    'item_img_exp'     => '商品画像管理にアップした、画像のファイル名を指定',
  ],
  'manage' => [
    'card_title'     => '販売管理マスタのcsv項目名とルール',
    'product_code_exp'     => '店舗で販売する商品コードを入力。登録されていない商品コードはエラーとなります',
    'store_code_exp'     => '商品を販売する店舗コードを入力。登録されていない店舗コードはエラーとなります',
    'p_type'     => '価格設定	',
    'price_type'     => 'price_type',
    'price_type_exp'     => '価格表示を設定',
    'price_type_0'     => '0:通常価格',
    'price_type_1'     => '1:最低価格',
    'price_type_2'     => '2:最高価格',
    'price_type_note'     => '0～3のいずれかを入力',
    'price_title'     => '販売価格',
    'price'     => 'price',
    'price_exp'     => '店舗での販売価格を入力。価格設定なしの場合は、価格は非表示となります。それ以外で入力のない場合は商品マスタの定価を表示します',
    'price_note'     => '数値のみ使用可能',
    'value_title'     => 'セール価格',
    'value'     => 'value',
    'value_exp'     => '店舗でのセール価格を入力',
    'value_note'     => '数値のみ使用可能',
    'start_date_title'     => 'セール開始時刻',
    'start_date'     => 'start_date',
    'start_date_exp'     => '店舗でのセールの開始時刻を入力',
    'start_date_note'     => '【入力例】2000/01/01 13:00',
    'end_date_title'     => 'セール終了時刻',
    'end_date'     => 'end_date',
    'end_date_exp'     => '店舗でのセールの終了時刻を入力',
    'end_date_note'     => '【入力例】2000/01/01 23:59',
    'sort_num_title'     => '店舗内表示順序',
    'sort_num'     => 'sort_num',
    'sort_num_exp'     => '店舗内での商品表示順序を設定',
    'sort_num_note'     => '数値のみ使用可能です',
    'stock_amount_title'     => '在庫数',
    'stock_amount'     => 'stock_amount',
    'stock_amount_exp'     => '店舗で扱っている商品の在庫数を入力',
    'stock_amount_note'     => '数値のみ使用可能',
    'stock_set_title'     => '在庫設定',
    'stock_set'     => 'stock_set',
    'stock_set0'     => '0：しない',
    'stock_set1'     => '1：する',
    'stock_set_exp'     => '在庫設定をするか、しないかを設定',
    'stock_set_note'     => '在庫設定のない商品は、「0」を入力してください',
    'catch_copy_title'     => 'キャッチコピー',
    'catch_copy'     => 'catch_copy',
    'catch_copy_exp'     => '店舗ごとに商品に対する説明を追記できます',
    'shelf_number_title'     => '棚番号',
    'shelf_number'     => 'shelf_number',
    'shelf_number_exp'     => '商品が置いてある棚番号を記入できます',
    'selling_flag_title'     => '取扱フラグ',
    'selling_flag'     => 'selling_flag',
    'selling_flag0'     => '0:取扱なし',
    'selling_flag1'     => '1:取扱あり',
    'selling_flag_exp'     => '商品の取り扱いを設定',
  ],
  'catalog' => [
    'card_title'     => 'カタログ出品csvの項目名とルール',
    'barcode_title'     => 'バーコード(JANコード)',
    'barcode'     => 'barcode',
    'barcode_exp'     => '出品したい商品のバーコードを入力。メーカーによる商品マスタへの登録がある場合は、コピーによる出品が可能です',
    'barcode_note'     => '半角英数のみ使用可能です。',
  ],
];

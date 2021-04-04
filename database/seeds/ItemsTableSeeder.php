<?php

use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('items')->insert([
        'company_id' => '1',
        'barcode' => '4527772091068',
        'product_code' => 'EHR66038-BE-F',
        'product_name' => 'DEVICE フォルマ3way リュック -ベージュ',
        'brand_name' => 'DEVICE',
        'category_id' => '4',
        'display_flag' => '1',
        'original_price' => '4950',
        'description' => '魔法のようにすぐ変形する3wayリュック。最近人気がないよ。',
        'tag' => 'リュック リュックサック ボディバッグ ショルダーバッグ 3way',
        'group_code_id' => '1',
        'storemap_category_id' => null,
        'item_img1' => 'ameyoko1.jpg',
        'item_img2' => 'ameyoko2.jpg',
        'item_img3' => 'ameyoko3.jpg',
        'item_img4' => 'ameyoko4.jpg',
        'item_img5' => 'ameyoko5.jpg',
        'item_img6' => 'ameyoko6.jpg',
        'item_img7' => 'ameyoko7.jpg',
        'item_img8' => 'ameyoko8.jpg',
        'item_img9' => 'ameyoko9.jpg',
        'item_img10' => 'ameyoko10.jpg',
        'item_status' => '1',
        'global_flag' => '1',
      ]);
      DB::table('items')->insert([
        'company_id' => '1',
        'barcode' => '4527772091044',
        'product_code' => 'EHR66038-BK-F',
        'product_name' => 'DEVICE フォルマ3way リュック -ブラック',
        'brand_name' => 'DEVICE',
        'category_id' => '3',
        'display_flag' => '1',
        'original_price' => '4950',
        'description' => '魔法のようにすぐ変形する3wayリュック。最近人気がないよ。',
        'tag' => 'リュック リュックサック ボディバッグ ショルダーバッグ 3way',
        'group_code_id' => '1',
        // 'storemap_category_id' => '2',
        'item_img1' => 'ameyoko21.jpg',
        'item_img2' => 'ameyoko22.jpg',
        'item_img3' => 'ameyoko23.jpg',
        'item_img4' => 'ameyoko24.jpg',
        'item_img5' => 'ameyoko25.jpg',
        'item_img6' => 'ameyoko26.jpg',
        'item_img7' => 'ameyoko27.jpg',
        'item_img8' => 'ameyoko28.jpg',
        'item_img9' => 'ameyoko29.jpg',
        'item_img10' => 'ameyoko210.jpg',
        'storemap_category_id' => null,
        'item_status' => '1',
        'global_flag' => '1',
      ]);
      DB::table('items')->insert([
        'company_id' => '1',
        'barcode' => '4527772091075',
        'product_code' => 'EHR66038-BR-F',
        'product_name' => 'DEVICE フォルマ3way リュック -ブラウン',
        'brand_name' => 'DEVICE',
        'category_id' => '2',
        'display_flag' => '1',
        'original_price' => '4950',
        'description' => '魔法のようにすぐ変形する3wayリュック。最近人気がないよ。',
        'tag' => 'リュック リュックサック ボディバッグ ショルダーバッグ 3way',
        'group_code_id' => '1',
        // 'storemap_category_id' => '1',
        'item_img1' => 'ameyoko31.jpg',
        'item_img2' => 'ameyoko32.jpg',
        'item_img3' => 'ameyoko33.jpg',
        'item_img4' => 'ameyoko34.jpg',
        'item_img5' => 'ameyoko35.jpg',
        'item_img6' => 'ameyoko36.jpg',
        'item_img7' => 'ameyoko37.jpg',
        'item_img8' => 'ameyoko38.jpg',
        'item_img9' => 'ameyoko39.jpg',
        'item_img10' => 'ameyoko310.jpg',
        'storemap_category_id' => null,
        'item_status' => '1',
        'global_flag' => '1',
      ]);
      DB::table('items')->insert([
        'company_id' => '1',
        'barcode' => '4527772091051',
        'product_code' => 'EHR66038-KH-F',
        'product_name' => 'DEVICE フォルマ3way リュック -カーキ',
        'brand_name' => 'DEVICE',
        'category_id' => '4',
        'display_flag' => '1',
        'original_price' => '4950',
        'description' => '魔法のようにすぐ変形する3wayリュック。最近人気がないよ。',
        'tag' => 'リュック リュックサック ボディバッグ ショルダーバッグ 3way',
        'group_code_id' => '1',
        // 'storemap_category_id' => '4',
        'item_img1' => 'ameyoko31.jpg',
        'item_img2' => 'ameyoko32.jpg',
        'item_img3' => 'ameyoko33.jpg',
        'item_img4' => 'ameyoko34.jpg',
        'item_img5' => 'ameyoko35.jpg',
        'item_img6' => 'ameyoko36.jpg',
        'item_img7' => 'ameyoko37.jpg',
        'item_img8' => 'ameyoko38.jpg',
        'item_img9' => 'ameyoko39.jpg',
        'item_img10' => 'ameyoko310.jpg',
        'storemap_category_id' => null,
        'item_status' => '0',
        'global_flag' => '1',
      ]);
      DB::table('items')->insert([
        'company_id' => '1',
        'barcode' => '4527772091082',
        'product_code' => 'EHR66038-NA-F',
        'product_name' => 'DEVICE フォルマ3way リュック -ナチュラル',
        'brand_name' => 'DEVICE',
        'category_id' => '4',
        'display_flag' => '1',
        // 'storemap_category_id' => '5',
        'original_price' => '4950',
        'description' => '魔法のようにすぐ変形する3wayリュック。最近人気がないよ。',
        'tag' => 'リュック リュックサック ボディバッグ ショルダーバッグ 3way',
        'group_code_id' => '1',
        'storemap_category_id' => null,
        'item_status' => '0',
        'global_flag' => '1',
      ]);
      DB::table('items')->insert([
        'company_id' => '1',
        'barcode' => '4527772091778',
        'product_code' => 'EHS67025-BE-F',
        'product_name' => 'COLSTA 2WAYショルダー -ベージュ',
        'brand_name' => 'COLSTA',
        'category_id' => '5',
        'display_flag' => '1',
        'original_price' => '2700',
        'description' => 'ウォッシュキャンバス地のラフな風合いが、どんなスタイルにも似合うショルダーバッグ★
マチ付きなので見た目よりも入る収納力が魅力的！前面・背面と合わせて4箇所あるポケットや、中の物が取り出し可能な背面の大きいファスナーなど使い勝手も抜群♪
付け位置が自由に変えれるストラップによって、ショルダーバッグ・メッセンジャーバッグ・口折れショルダーバッグとアレンジができるお得なデザインです♪
内部には小物用ポケットが2つ付いており小物収納にも便利！
毎日のタウンユースにぴったりの、おすすめバッグです。',
        'tag' => 'ショルダーバッグ 2way 帆布 斜めがけ メンズ レディース',
        'group_code_id' => '2',
        'storemap_category_id' => null,
        'item_status' => '0',
        'global_flag' => '1',
      ]);
      DB::table('items')->insert([
        'company_id' => '1',
        'barcode' => '4527772091754',
        'product_code' => 'EHS67025-BK-F',
        'product_name' => 'COLSTA 2WAYショルダー -ブラック',
        'brand_name' => 'COLSTA',
        'category_id' => '6',
        'display_flag' => '1',
        'original_price' => '2700',
        'description' => 'ウォッシュキャンバス地のラフな風合いが、どんなスタイルにも似合うショルダーバッグ★
マチ付きなので見た目よりも入る収納力が魅力的！前面・背面と合わせて4箇所あるポケットや、中の物が取り出し可能な背面の大きいファスナーなど使い勝手も抜群♪
付け位置が自由に変えれるストラップによって、ショルダーバッグ・メッセンジャーバッグ・口折れショルダーバッグとアレンジができるお得なデザインです♪
内部には小物用ポケットが2つ付いており小物収納にも便利！
毎日のタウンユースにぴったりの、おすすめバッグです。',
        'tag' => 'ショルダーバッグ 2way 帆布 斜めがけ メンズ レディース',
        'group_code_id' => '2',
        'storemap_category_id' => null,
        'item_status' => '0',
        'global_flag' => '1',
      ]);
      DB::table('items')->insert([
        'company_id' => '1',
        'barcode' => '4527772091785',
        'product_code' => 'EHS67025-BR-F',
        'product_name' => 'COLSTA 2WAYショルダー -ブラウン',
        'brand_name' => '',
        'category_id' => '7',
        'display_flag' => '1',
        'original_price' => '2700',
        'description' => 'ウォッシュキャンバス地のラフな風合いが、どんなスタイルにも似合うショルダーバッグ★
マチ付きなので見た目よりも入る収納力が魅力的！前面・背面と合わせて4箇所あるポケットや、中の物が取り出し可能な背面の大きいファスナーなど使い勝手も抜群♪
付け位置が自由に変えれるストラップによって、ショルダーバッグ・メッセンジャーバッグ・口折れショルダーバッグとアレンジができるお得なデザインです♪
内部には小物用ポケットが2つ付いており小物収納にも便利！
毎日のタウンユースにぴったりの、おすすめバッグです。',
        'tag' => 'ショルダーバッグ 2way 帆布 斜めがけ メンズ レディース',
        'group_code_id' => '2',
        'storemap_category_id' => null,
        'item_status' => '0',
        'global_flag' => '1',
      ]);
      DB::table('items')->insert([
        'company_id' => '1',
        'barcode' => '4527772091761',
        'product_code' => 'EHS67025-KH-F',
        'product_name' => 'COLSTA 2WAYショルダー -カーキ',
        'category_id' => '1',
        'display_flag' => '0',
        'original_price' => '2700',
        'storemap_category_id' => null,
        'description' => 'ウォッシュキャンバス地のラフな風合いが、どんなスタイルにも似合うショルダーバッグ★
マチ付きなので見た目よりも入る収納力が魅力的！前面・背面と合わせて4箇所あるポケットや、中の物が取り出し可能な背面の大きいファスナーなど使い勝手も抜群♪
付け位置が自由に変えれるストラップによって、ショルダーバッグ・メッセンジャーバッグ・口折れショルダーバッグとアレンジができるお得なデザインです♪
内部には小物用ポケットが2つ付いており小物収納にも便利！
毎日のタウンユースにぴったりの、おすすめバッグです。',
        'tag' => 'ショルダーバッグ 2way 帆布 斜めがけ メンズ レディース',
        'group_code_id' => '2',
        // 'storemap_category_id' => '3',
        'item_status' => '1',
      ]);
//       DB::table('items')->insert([
//         'company_id' => '1',
//         'barcode' => '4527772133102',
//         'product_code' => 'RTG30028-BR-F',
//         'product_name' => 'Rename スクエア ビッグ トートバッグ -ブラウン',
//         'category_id' => '3',
//         'display_flag' => '0',
//         'original_price' => '3024',
//         'description' => '人気ブランドRenameシリーズの、スクエアタイプトートバッグ！
// A3用紙や雑誌も入るビッグサイズだから、通勤・通学から旅行にまで幅広く使えること間違いなし！
// シンプルなデザインだから、どんなスタイルにもマッチ。背面ポケットや、内装ポケットもあるから小物整理もバッチリ！
// 開口も大きく荷物の出し入れも簡単！機能性抜群でオシャレなトートバッグです。',
//         'size' => 'L',
//         'color' => 'ブラウン',
//         'tag' => 'トートバッグ 合皮 メンズ レディース',
//         'group_code_id' => '3',
//         'global_category_id' => '2',
//         'item_status' => '0',
//       ]);
//       DB::table('items')->insert([
//         'company_id' => '1',
//         'barcode' => '4527772133034',
//         'product_code' => 'RTG30028-BK-F',
//         'product_name' => 'Rename スクエア ビッグ トートバッグ -ブラック',
//         'category_id' => '3',
//         'display_flag' => '0',
//         'original_price' => '3024',
//         'description' => '人気ブランドRenameシリーズの、スクエアタイプトートバッグ！
// A3用紙や雑誌も入るビッグサイズだから、通勤・通学から旅行にまで幅広く使えること間違いなし！
// シンプルなデザインだから、どんなスタイルにもマッチ。背面ポケットや、内装ポケットもあるから小物整理もバッチリ！
// 開口も大きく荷物の出し入れも簡単！機能性抜群でオシャレなトートバッグです。',
//         'size' => 'XL',
//         'color' => 'ブラック',
//         'tag' => 'トートバッグ 合皮 メンズ レディース',
//         'group_code_id' => '3',
//         'global_category_id' => '5',
//         'item_status' => '0',
//       ]);
      DB::table('items')->insert([
        'company_id' => '1',
        'barcode' => '4527772133041',
        'product_code' => 'RTG30028-CA-F',
        'product_name' => 'Rename スクエア ビッグ トートバッグ -キャメル',
        'brand_name' => 'Rename',
        'category_id' => '3',
        'display_flag' => '1',
        'original_price' => '3024',
        'description' => '人気ブランドRenameシリーズの、スクエアタイプトートバッグ！
A3用紙や雑誌も入るビッグサイズだから、通勤・通学から旅行にまで幅広く使えること間違いなし！
シンプルなデザインだから、どんなスタイルにもマッチ。背面ポケットや、内装ポケットもあるから小物整理もバッチリ！
開口も大きく荷物の出し入れも簡単！機能性抜群でオシャレなトートバッグです。',
        'tag' => 'トートバッグ 合皮 メンズ レディース',
        'group_code_id' => '3',
        'storemap_category_id' => null,
        'item_status' => '0',
      ]);
      DB::table('items')->insert([
        'company_id' => '1',
        'barcode' => '4527772117362',
        'product_code' => 'RTG30028-KH-F',
        'product_name' => 'Rename スクエア ビッグ トートバッグ -カーキ',
        'brand_name' => 'Rename',
        'category_id' => '3',
        'display_flag' => '1',
        'original_price' => '3024',
        'description' => '人気ブランドRenameシリーズの、スクエアタイプトートバッグ！
A3用紙や雑誌も入るビッグサイズだから、通勤・通学から旅行にまで幅広く使えること間違いなし！
シンプルなデザインだから、どんなスタイルにもマッチ。背面ポケットや、内装ポケットもあるから小物整理もバッチリ！
開口も大きく荷物の出し入れも簡単！機能性抜群でオシャレなトートバッグです。',
        'tag' => 'トートバッグ 合皮 メンズ レディース',
        'group_code_id' => '3',
        'storemap_category_id' => null,
        'item_status' => '0',
      ]);
//       DB::table('items')->insert([
//         'company_id' => '1',
//         'barcode' => '4527772133133',
//         'product_code' => 'RTG30028-NV-F',
//         'product_name' => 'Rename スクエア ビッグ トートバッグ -ネイビー',
//         'category_id' => '3',
//         'display_flag' => '0',
//         'original_price' => '3024',
//         'description' => '人気ブランドRenameシリーズの、スクエアタイプトートバッグ！
// A3用紙や雑誌も入るビッグサイズだから、通勤・通学から旅行にまで幅広く使えること間違いなし！
// シンプルなデザインだから、どんなスタイルにもマッチ。背面ポケットや、内装ポケットもあるから小物整理もバッチリ！
// 開口も大きく荷物の出し入れも簡単！機能性抜群でオシャレなトートバッグです。',
//         'size' => 'M',
//         'color' => 'ネイビー',
//         'tag' => 'トートバッグ 合皮 メンズ レディース',
//         'group_code_id' => '3',
//         'global_category_id' => '2',
//         'item_status' => '0',
//       ]);
//       DB::table('items')->insert([
//         'company_id' => '1',
//         'barcode' => '4527772120751',
//         'product_code' => 'DPG20038-BK-F',
//         'product_name' => 'DEVICE gland 二つ折り財布 -ブラック',
//         'category_id' => '2',
//         'display_flag' => '0',
//         'original_price' => '4104',
//         'description' => '両サイドにコインケースを備えたシンプルな二つ折り財布。ジッパーポケットが二つあるため、
// 一方をコインケースとして、もう一方は鍵や切符などすぐに取り出したい小物を入れるのに便利です。
// シンプルでスタンダードなデザインだから、飽きずにずっと使えるのも嬉しいポイント。
// 素材にはラムスキンのような雰囲気を持ったフェイクレザーを使用。持ったときに心地よいと感じられる
// くらいのちょうど良い柔らかさとヴィンテージ感が特徴です。
// 程よいサイズ感だからパンツのバックポケットに入れて持ち歩くのにピッタリで、手ぶらスタイルが多い
// という方に、ドンズバのオススメ財布です。',
//         'size' => 'ブラック',
//         'color' => '1',
//         'tag' => '財布 二つ折り財布 ウォレット メンズ レディース',
//         'group_code_id' => '4',
//         'global_category_id' => '3',
//         'item_status' => '0',
//       ]);
//       DB::table('items')->insert([
//         'company_id' => '1',
//         'barcode' => '4527772120768',
//         'product_code' => 'DPG20038-BR-F',
//         'product_name' => 'DEVICE gland 二つ折り財布 -ブラウン',
//         'category_id' => '2',
//         'display_flag' => '0',
//         'original_price' => '4104',
//         'description' => '両サイドにコインケースを備えたシンプルな二つ折り財布。ジッパーポケットが二つあるため、
//       一方をコインケースとして、もう一方は鍵や切符などすぐに取り出したい小物を入れるのに便利です。
//       シンプルでスタンダードなデザインだから、飽きずにずっと使えるのも嬉しいポイント。
//       素材にはラムスキンのような雰囲気を持ったフェイクレザーを使用。持ったときに心地よいと感じられる
//       くらいのちょうど良い柔らかさとヴィンテージ感が特徴です。
//       程よいサイズ感だからパンツのバックポケットに入れて持ち歩くのにピッタリで、手ぶらスタイルが多い
//       という方に、ドンズバのオススメ財布です。',
//         'size' => 'F',
//         'color' => 'ブラウン',
//         'tag' => '財布 二つ折り財布 ウォレット メンズ レディース',
//         'group_code_id' => '4',
//         'global_category_id' => '4',
//         'item_status' => '0',
//       ]);
//       DB::table('items')->insert([
//         'company_id' => '1',
//         'barcode' => '4527772120775',
//         'product_code' => 'DPG20038-CA-F',
//         'product_name' => 'DEVICE gland 二つ折り財布 -キャメル',
//         'category_id' => '2',
//         'display_flag' => '0',
//         'original_price' => '4104',
//         'description' => '両サイドにコインケースを備えたシンプルな二つ折り財布。ジッパーポケットが二つあるため、
//       一方をコインケースとして、もう一方は鍵や切符などすぐに取り出したい小物を入れるのに便利です。
//       シンプルでスタンダードなデザインだから、飽きずにずっと使えるのも嬉しいポイント。
//       素材にはラムスキンのような雰囲気を持ったフェイクレザーを使用。持ったときに心地よいと感じられる
//       くらいのちょうど良い柔らかさとヴィンテージ感が特徴です。
//       程よいサイズ感だからパンツのバックポケットに入れて持ち歩くのにピッタリで、手ぶらスタイルが多い
//       という方に、ドンズバのオススメ財布です。',
//         'size' => 'S',
//         'color' => 'キャメル',
//         'tag' => '財布 二つ折り財布 ウォレット メンズ レディース',
//         'group_code_id' => '4',
//         'global_category_id' => '5',
//         'item_status' => '0',
//       ]);
//       DB::table('items')->insert([
//         'company_id' => '1',
//         'barcode' => '4527772124643',
//         'product_code' => 'DCH30019-BE-F',
//         'product_name' => 'DEVICE Access シザーケース -ベージュ',
//         'category_id' => '5',
//         'display_flag' => '0',
//         'original_price' => '2530',
//         'description' => 'DEVICE Accessシリーズの2wayシザーケース。
// 新品でも使い込んだ雰囲気を作り出すために、独特のケミカルウォッシュ加工を施した帆布生地を使用。また部分使いされた本革(レザー)が、ヴィンテージ感をプラス。
// 付属のベルトでショルダーバッグとしても使用できる2way仕様!
// メインルームはもちろん本体前面のかぶせポケットにもスマートフォン収納可能！
// その他、財布や鍵など必要最低限の持ち物が収まる普段使いに便利なアイテム。',
//         'size' => 'M',
//         'color' => 'ベージュ',
//         'tag' => 'シザーケース ミニショルダー ポーチ メンズ シザーバッグ カバン 鞄',
//         'group_code_id' => '5',
//         'global_category_id' => '1',
//         'item_status' => '0',
//       ]);
//       DB::table('items')->insert([
//         'company_id' => '1',
//         'barcode' => '4527772124650',
//         'product_code' => 'DCH30019-BK-F',
//         'product_name' => 'DEVICE Access シザーケース -ブラック',
//         'category_id' => '5',
//         'display_flag' => '0',
//         'original_price' => '2530',
//         'description' => 'DEVICE Accessシリーズの2wayシザーケース。
// 新品でも使い込んだ雰囲気を作り出すために、独特のケミカルウォッシュ加工を施した帆布生地を使用。また部分使いされた本革(レザー)が、ヴィンテージ感をプラス。
// 付属のベルトでショルダーバッグとしても使用できる2way仕様!
// メインルームはもちろん本体前面のかぶせポケットにもスマートフォン収納可能！
// その他、財布や鍵など必要最低限の持ち物が収まる普段使いに便利なアイテム。',
//         'size' => 'F',
//         'color' => 'ブラック',
//         'tag' => 'シザーケース ミニショルダー ポーチ メンズ シザーバッグ カバン 鞄',
//         'group_code_id' => '5',
//         'global_category_id' => '2',
//         'item_status' => '0',
//       ]);
//       DB::table('items')->insert([
//         'company_id' => '1',
//         'barcode' => '4527772124667',
//         'product_code' => 'DCH30019-BR-F',
//         'product_name' => 'DEVICE Access シザーケース -ブラウン',
//         'category_id' => '5',
//         'display_flag' => '0',
//         'original_price' => '2530',
//         'description' => 'DEVICE Accessシリーズの2wayシザーケース。
// 新品でも使い込んだ雰囲気を作り出すために、独特のケミカルウォッシュ加工を施した帆布生地を使用。また部分使いされた本革(レザー)が、ヴィンテージ感をプラス。
// 付属のベルトでショルダーバッグとしても使用できる2way仕様!
// メインルームはもちろん本体前面のかぶせポケットにもスマートフォン収納可能！
// その他、財布や鍵など必要最低限の持ち物が収まる普段使いに便利なアイテム。',
//         'size' => 'F',
//         'color' => 'ブラウン',
//         'tag' => 'シザーケース ミニショルダー ポーチ メンズ シザーバッグ カバン 鞄',
//         'group_code_id' => '5',
//         'global_category_id' => '3',
//         'item_status' => '0',
//       ]);
//       DB::table('items')->insert([
//         'company_id' => '1',
//         'barcode' => '4527772124674',
//         'product_code' => 'DCH30019-KH-F',
//         'product_name' => 'DEVICE Access シザーケース -カーキ',
//         'category_id' => '5',
//         'display_flag' => '0',
//         'original_price' => '2530',
//         'description' => 'DEVICE Accessシリーズの2wayシザーケース。
// 新品でも使い込んだ雰囲気を作り出すために、独特のケミカルウォッシュ加工を施した帆布生地を使用。また部分使いされた本革(レザー)が、ヴィンテージ感をプラス。
// 付属のベルトでショルダーバッグとしても使用できる2way仕様!
// メインルームはもちろん本体前面のかぶせポケットにもスマートフォン収納可能！
// その他、財布や鍵など必要最低限の持ち物が収まる普段使いに便利なアイテム。',
//         'size' => 'F',
//         'color' => 'カーキ',
//         'tag' => 'シザーケース ミニショルダー ポーチ メンズ シザーバッグ カバン 鞄',
//         'group_code_id' => '5',
//         'global_category_id' => '4',
//         'item_status' => '0',
//       ]);
        factory(App\Models\Item::class, 5000)->create();
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoremapCategory;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

// https://github.com/lazychaser/laravel-nestedsetを使ってます

// SMカテゴリが変更されたときの処理
class SmCateController extends Controller
{
  public function getSecondLayer(Request $request)
  {
        // 空の変数を定義
        $html = '';
        // idで子供を取得
        $second_layers = StoremapCategory::descendantsOf($request->storemap_category_id)->toTree();
        // オプションを生成
        $html .= '<option value="" hidden>選択してください</option>';
        foreach ($second_layers as $second_layer) {
            $html .= '<option value="'.$second_layer->id.'">'.$second_layer->smcategory_name.'</option>';
        }
        // jsonで値を返す
    return response()->json(['html' => $html]);
  }

  public function getThirdLayer(Request $request)
  {

        $third_layers = StoremapCategory::descendantsOf($request->storemap_category_id)->toTree();
        if (isset($third_layers[0])){
          $html = '';
          $html .= '<option value="" hidden>選択してください</option>';
          foreach ($third_layers as $third_layer) {
            $html .= '<option value="'.$third_layer->id.'">'.$third_layer->smcategory_name.'</option>';
          }
        return response()->json(['html' => $html]);
        }

  }

  public function getFourthLayer(Request $request)
  {
        $fourth_layers = StoremapCategory::descendantsOf($request->storemap_category_id)->toTree();
        if(isset($fourth_layers[0])){
          $html = '';
          $html .= '<option value="" hidden>選択してください</option>';
          foreach ($fourth_layers as $fourth_layer) {
              $html .= '<option value="'.$fourth_layer->id.'">'.$fourth_layer->smcategory_name.'</option>';
          }
          return response()->json(['html' => $html]);
        }
  }

  public function getFifthLayer(Request $request)
  {
        $fifth_layers = StoremapCategory::descendantsOf($request->storemap_category_id)->toTree();
        if(isset($fifth_layers[0])){
          $html = '';
          $html .= '<option value="" hidden>選択してください</option>';
          foreach ($fifth_layers as $fifth_layer) {
              $html .= '<option value="'.$fifth_layer->id.'">'.$fifth_layer->smcategory_name.'</option>';
          }
          return response()->json(['html' => $html]);
        }
  }

  public function getSixthLayer(Request $request)
  {
        $sixth_layers = StoremapCategory::descendantsOf($request->storemap_category_id)->toTree();
        if(isset($sixth_layers[0])){
          $html = '';
          $html .= '<option value="" hidden>選択してください</option>';
          foreach ($sixth_layers as $sixth_layer) {
              $html .= '<option value="'.$sixth_layer->id.'">'.$sixth_layer->smcategory_name.'</option>';
          }
          return response()->json(['html' => $html]);
        }
  }

  public function smSearch(Request $request) {
    $keyword = $request->input('sm_search');
    $search_layers = StoremapCategory::where('smcategory_name', 'LIKE', '%'. $keyword .'%')->with('ancestors')->get();
    $html = '';
    $html .= '<option value="" hidden>選択してください</option>';
    foreach ($search_layers as $search_layer) {
      if($search_layer->ancestors->count()){
        $html .= '<option value="'.$search_layer->id.'"><small>'.implode(' > ', $search_layer->ancestors->pluck('smcategory_name')->toArray()).'</small>&nbsp;>&nbsp;<strong>'. $search_layer->smcategory_name .'</strong></option>';
      } else {
        $html .= '<small>Top Level</small>';
        }
      }
      return response()->json(['html' => $html]);
  }

  // SMカテゴリの検索を選択肢に反映するときの処理
  // public function smResult(Request $request) {
  //   $result = StoremapCategory::ancestorsAndSelf($request->id);
  //   return response()->json(['result' => $result]);
  //   }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use App\Http\Requests\CompanyRequest; //バリデーション
use App\Http\Requests\CompanyUpdateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; //ファイルアクセス
use Illuminate\Support\Facades\Schema;

class CompanyController extends Controller
{

  public function index()
  {
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {   //新規登録用
    $user = Auth::user();
    if (isset($user->company_id)) {
      return redirect("/company/show");
    } else {
      return view('company.create', compact('user'));
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CompanyRequest $request)
  {
    $user = Auth::user();

    if (isset($user->company_id)) {
      // 戻るボタンを使った２重登録防止
      return redirect("/company/show")->with('warning', '※会社情報が登録済みです');
    } 

    $company = new Company;
    $company->company_name = $request->company_name;
    $company->company_kana = $request->company_kana;
    // $company->company_code = $request->company_code;
    $company->company_postcode = $request->company_postcode;
    $company->prefecture = $request->prefecture;
    $company->company_city = $request->company_city;
    $company->company_adnum = $request->company_adnum;
    $company->company_apart = $request->company_apart;
    $company->company_phone_number = $request->company_phone_number;
    $company->company_fax_number = $request->company_fax_number;
    $company->manager_name = $request->manager_name;
    $company->manager_kana = $request->manager_kana;
    $company->site_url = $request->site_url;
    $company->maker_flag = $request->maker_flag;
    if ($company->maker_flag == 1) {
      $company->img_flag = $request->img_flag;
      $company->gs1_company_prefix = $request->gs1_company_prefix;
    } else {
      $company->img_flag = 0;
      $company->gs1_company_prefix = null;
    }
    $company->save();
    //$last_insert_id で最後に入力したIDを取得
    $last_insert_id = $company->id;
    // 取り出したIDをuserのcidに入力

    if (isset($request->certificate)) {
      // ファイル情報取得
      $file = $request->file('certificate');
      // storage/files/certificateに会社証明のファイル保存
      Storage::disk('local')->putFileAs('files/certificate/', $request->file('certificate'), 'company_' . $last_insert_id . '.' . $file->getClientOriginalExtension());
      $company = Company::find($last_insert_id);
      $company->certificate = 'company_' . $last_insert_id . '.' . $file->getClientOriginalExtension();
      $company->save();
    }

    $user->company_id = $last_insert_id;
    $user->save();

    return redirect("/payment/card")->with('success', '※会社情報を登録しました。不正利用防止と本人確認のため、最初にお支払いカード情報の登録をお願い致します。');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Company  $company
   * @return \Illuminate\Http\Response
   */
  public function show()
  {

    $user = Auth::user();
    // $company = DB::table('companies')->w/here('id', $user->company_id)->first();
    $company = Company::where('id', $user->company_id)->first();

    $this->authorize('view', $company); // policy tableからとったらエラーなるよ

    return view('company.show', compact('user', 'company'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Company  $company
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $user = Auth::user();
    // $company = DB::table('companies')->where('id', $user->company_id)->first();
    $company = Company::find($id);
    $this->authorize('update', $company);

    return view('company.edit', compact('user', 'company'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Company  $company
   * @return \Illuminate\Http\Response
   */
  public function update(CompanyUpdateRequest $request, $id)
  {
    $company = Company::find($id);

    $this->authorize('update', $company); // policy

    $company->company_name = $request->company_name;
    $company->company_kana = $request->company_kana;
    $company->company_postcode = $request->company_postcode;
    $company->prefecture = $request->prefecture;
    $company->company_city = $request->company_city;
    $company->company_adnum = $request->company_adnum;
    $company->company_apart = $request->company_apart;
    $company->company_phone_number = $request->company_phone_number;
    $company->company_fax_number = $request->company_fax_number;
    $company->manager_name = $request->manager_name;
    $company->manager_kana = $request->manager_kana;
    $company->site_url = $request->site_url;
    $company->maker_flag = $request->maker_flag;

    if ($company->maker_flag == 1) {
      $company->img_flag = $request->img_flag;
      $company->gs1_company_prefix = $request->gs1_company_prefix;
    } else {
      $company->img_flag = 0;
      $company->gs1_company_prefix = null;
    }

    // ファイル情報取得
    $file = $request->file('certificate');
    // storage/files/certificateに会社証明のファイル保存

    if (isset($request->certificate)) {

      Storage::disk('local')->delete('files/certificate/' . $company->certificate);

      Storage::disk('local')->putFileAs('files/certificate/', $request->file('certificate'), 'company_' . $id . '.' . $file->getClientOriginalExtension());
      $company->certificate = 'company_' . $id . '.' . $file->getClientOriginalExtension();
    }

    $company->save();

    return redirect("/company/show")->with([
      'company' => $company,
      'success' => '※会社情報を更新しました',
    ]);
  }
  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Company  $company
   * @return \Illuminate\Http\Response
   */
  public function destroy(Company $company)
  {
    //
  }

  public function download()
  {
    $user = Auth::user();
    $company = DB::table('companies')->where('id', $user->company_id)->first();
    return Storage::disk('local')->download('files/certificate/' . $company->certificate);
  }
}

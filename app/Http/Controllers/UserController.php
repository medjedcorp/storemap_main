<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest; //バリデーション
use App\Http\Requests\UserUpdateRequest; //バリデーション
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; //ファイルアクセス
use Illuminate\Auth\Events\Registered; // 追加登録のメール送信
use Gate;
// use Session;

class UserController extends Controller
{

  public function index(Request $request)
  {
    $user = Auth::user();
    $cid = $user->company_id;
    $users = User::where('company_id', $cid)->get();
    $c_name = Company::where('id', $cid)->pluck('company_name')->first();

    // 検索からキーワード取得
    $keyword = $request->input('keyword');

    if (isset($keyword)) {
      // カンパニーIDでセグメントしてから、orWhereのいずれかにあてはまったものを抽出
      $users = User::select(['id', 'name', 'email', 'role'])->where('company_id', $cid)->where(function ($query) use ($keyword) {
        $query->orWhere('name', 'like', '%' . $keyword . '%')
          ->orWhere('email', 'like', '%' . $keyword . '%');
      })->sortable()->paginate(20);
    } else {
      $users = User::select(['id', 'name', 'email', 'role'])->where('company_id', $cid)->sortable()->paginate(20); // ページ作成
    }
    $count = User::where('company_id', $cid)->get()->count();
    return view('users.index', [
      'users' => $users,
      'keyword' => $keyword,
      'count' => $count,
      'c_name' => $c_name,
    ]);

    // return view('users.index', compact( 'users', 'c_name'));
  }

  public function create()
  {
    $user = Auth::user();
    $company_id = $user->company_id;
    //   // company_idがないuserは会社登録ページへ飛ばす
    // if(!isset($user->company_id)){
    //   return redirect('/seller/company/create');
    // } else {
    //   $company = DB::table('companies')->where('id', $user->company_id)->first();
    //   return view('sellers.create', compact( 'user', 'company'));
    // }
    return view('users.create', compact('company_id'));
  }

  public function store(UserRequest $request)
  {
    $cid = Auth::user();
    $user = new User;
    $user->name = $request->name;
    $user->email = $request->email;
    // パスワードハッシュ化
    $user->password = \Hash::make($request['password']);
    if($cid->email === 'smsupport@storemap.jp'){
      $user->role = 'tester';
    } else {
      $user->role = $request->role;
    }
    
    $user->company_id = $cid->company_id;
    $user->save();

    event(new Registered($user));
    //   if ($user->fill($request->all())->save()) {
    //     // メール確認の為の仮登録完了メール送信
    //     event(new Registered($user));
    // }

    return redirect('/users')->with([
      'success' => '※' . $user->email . 'に確認メールを送信しました。メールアドレスのリンクをクリックすることで承認されます。',
      // 'success' => '※'.$user->name.'さんを登録しました',
    ]);
  }

  public function edit($id)
  {
    $user = User::find($id);
    $company = Company::where('id', $user->company_id)->first();
    $this->authorize('view', $company);

    $company_id = $user->company_id;
    $sid = Store::where('company_id', $user->company_id)->get();
    // $sid = DB::table('stores')->where('company_id', $user->company_id)->get();
    $store = User::find($id)->store()->orderBy('store_name')->get();
    return view('users.edit', compact('user', 'store', 'sid', 'company_id'));
  }

  public function update(UserUpdateRequest $request, $id)
  {
    $user = User::find($id);
    $company = Company::where('id', $user->company_id)->first();
    $this->authorize('update', $company);

    $user->name = $request->name;
    // $user->email = $request->email;
    $user->role = $request->role;
    $user->save();
    // ストアIDを中間テーブルに記入。formは配列で受け取れるようにnameに[]をつけること
    $user->store()->sync($request->store_id);

    // Session::flash('success', '※更新しました');
    return redirect()->action('UserController@edit', [$user->id])->with([
      'success' => '※更新しました',
    ]);
  }

  public function destroy($id)
  {
    $user = Auth::user();
    // $user = User::find($id);
    $myid = $user->id;
    $deluser = User::find($id);
    $company = Company::where('id', $deluser->company_id)->first();
    Gate::authorize('isSeller'); // gate staffは削除不可
    if ($id == $myid) {
      return redirect('/users')->with('warning', '※自分は削除できません');
    } elseif(Gate::allows('delete-user', $company)) {
      // 現在のユーザーはこのユーザーを削除できる
      // Providers\AuthServiceProvider 参照
      $deluser->delete();
      return redirect('/users')->with('danger', '※ユーザーを削除しました');
    } else {
      return redirect('/users')->with('danger', '※削除に失敗しました');
    }
  }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Http\Request;
// use Validator,Redirect,Response;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Session;
use Gate;

class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $user = Auth::user();

    // 検索からキーワード取得
    $keyword = $request->input('keyword');
    $cid = $user->company_id;
    $c_name = Company::where('id', $cid)->pluck('company_name')->first();
    
    if ($user->role === 'admin') {
      // adminの場合
      if (isset($keyword)) {
        // カンパニーIDでセグメントしてから、orWhereのいずれかにあてはまったものを抽出
        $categories = Category::select(['id', 'category_code', 'category_name', 'display_flag', 'company_id'])->where(function ($query) use ($keyword) {
          $query->orWhere('category_code', 'like', '%' . $keyword . '%')
            ->orWhere('category_name', 'like', '%' . $keyword . '%');
        })->sortable()->paginate(20);
      } else {
        $categories = Category::select(['id', 'category_code', 'category_name', 'display_flag', 'company_id'])->sortable()->paginate(20); // ページ作成
      }
      $count = Category::count();
    } else {
      // admin以外の場合
      if (isset($keyword)) {
        // カンパニーIDでセグメントしてから、orWhereのいずれかにあてはまったものを抽出
        $categories = Category::select(['id', 'category_code', 'category_name', 'display_flag'])->where('company_id', $cid)->where(function ($query) use ($keyword) {
          $query->orWhere('category_code', 'like', '%' . $keyword . '%')
            ->orWhere('category_name', 'like', '%' . $keyword . '%');
        })->sortable()->paginate(20);
      } else {
        $categories = Category::select(['id', 'category_code', 'category_name', 'display_flag'])->where('company_id', $cid)->sortable()->paginate(20); // ページ作成
      }
      $count = Category::where('company_id', $cid)->get()->count();
    }

    
    return view('categories.index', [
      'categories' => $categories,
      'keyword' => $keyword,
      'count' => $count,
      'c_name' => $c_name,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $user = Auth::user();
    $company_id = $user->company_id;

    // return view('categories.create')->with(['company_id' => $company_id]);
    return view('categories.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CategoryRequest $request)
  {
    $category = new Category;
    $user = Auth::user();
    $category->category_code = $request->category_code;
    $category->category_name = $request->category_name;
    if ($user->role === "admin") {
      $category->company_id = $request->company_id;
    } else {
      $category->company_id = $user->company_id;
    }
    $category->display_flag = $request->display_flag;
    $category->save();

    return redirect('/categories/create')->with('success', '※' . $category->category_name . 'を登録しました');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function show(Category $category)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $category = Category::find($id);
    $this->authorize('update', $category); // policy

    $user = Auth::user();
    // $company_id = $user->company_id;
    return view('categories.edit', compact('category'));
    // return view('categories.edit', compact('category', 'company_id'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function update(CategoryRequest $request, $id)
  {
    $category = Category::find($id);
    $this->authorize('update', $category); // policy
    $user = Auth::user();
    $category->category_code = $request->category_code;
    $category->category_name = $request->category_name;
    $category->display_flag = $request->display_flag;
    
    if ($user->role === "admin") {
      $category->company_id = $request->company_id;
    }
    $category->save();

    return back()->with([
      'category' => $category,
      'success' => '※' . $category->category_name . 'に変更しました',
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $category = Category::find($id);

    Gate::authorize('isFree'); // gate staffは削除不可

    $this->authorize('delete', $category); // policy

    $category->delete();
    return redirect('/categories')->with('danger', '※カテゴリを削除しました');
  }
}

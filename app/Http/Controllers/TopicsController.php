<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic; // 追加
use Gate;

class TopicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $topics = topic::latest()->get();
    //     return view('home', ['topics' => $topics]);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('isAdmin'); // Providers\AuthServiceProvideでGate設定

        $headers = [
            '0' => '機能情報',
            '1' => '販促情報',
            '2' => 'メンテナンス',
            '3' => '障害',
            '4' => 'お知らせ',
            '5' => 'その他',
        ];
        return view('topics.create', compact('headers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('isAdmin'); // Providers\AuthServiceProvideでGate設定

        $params = $request->validate([
            'title' => 'required|max:50',
            'info' => 'required|max:10|in:0,1,2,3,4,5',
            'content' => 'required|max: 800',
        ]);

        Topic::create($params);

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $topic = Topic::where('id', $id)->first();

        return view('topics.show',compact('topic'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Gate::authorize('isAdmin'); // Providers\AuthServiceProvideでGate設定
        $topic = Topic::where('id', $id)->first();
        $headers = [
            '0' => '機能情報',
            '1' => '販促情報',
            '2' => 'メンテナンス',
            '3' => '障害',
            '4' => 'お知らせ',
            '5' => 'その他',
        ];
        return view('topics.edit', compact('topic', 'headers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('isAdmin'); // Providers\AuthServiceProvideでGate設定
        $params = $request->validate([
            'title' => 'required|max:50',
            'info' => 'required|max:10|in:0,1,2,3,4,5',
            'content' => 'required|max:800',
        ]);

        $topic = Topic::where('id', $id)->first();
        $topic->fill($params)->save();

        return redirect()->route('topics.show', [$topic->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('isAdmin'); // Providers\AuthServiceProvideでGate設定
        $topic = Topic::where('id', $id)->first();
        $topic->delete();
        return redirect()->route('home');
    }
}

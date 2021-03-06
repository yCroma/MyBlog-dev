<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::latest()->paginate(9);

        // 描画用のタグ一覧
        $view_tags = Tag::all();
        return view('tags.index', [
            'tags' => $tags,
            'view_tags' => $view_tags
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tag = Tag::create([
            'name' => $request->new_tag,
        ]);
        $id = $tag->id;
        return redirect(route('tags.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        $id = $tag->id;
        // $articles = Tag::find($id)->articles;
        // タグに関係を持っている記事を取得(新しい順)
        $articles = Tag::find($id)->articles()
                            ->withPivot('created_at')
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        // 描画用のタグ一覧
        $view_tags = Tag::all();

        return view('tags.show',[
            'tag' => $tag,
            'articles' => $articles,
            'view_tags' => $view_tags
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $id = $tag->id;
        Tag::destroy($id);
        return redirect(route('tags.index'));
    }
}

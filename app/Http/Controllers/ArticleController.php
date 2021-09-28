<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $submittedArticles = Article::where('status', 1)->paginate(5);

        $articles = Article::where('status', 2)->paginate(5);

        return view('articles.index', compact('articles', 'submittedArticles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        Auth::user()->cannot('create', Article::class) ?  abort(403) : true;

        $request->validate([
            'title' => 'required|min:3|max:50',
            'content' => 'required',
            'file_content' => 'nullable|mimes:pdf|max:2000',
            'image_content' => 'nullable|mimes:pdf|max:2000',
        ]);

        $article = Article::create($request->all());
        $article->user_id = Auth::user()->id;
        $article->status  = ($request->has('draft')) ? 0 : 1;

        if ($request->file_content != null) {
            $article->file_content = $request->file('file_content')->storeAs(
                'articles',
                'file_sharing' . $article->title . '_' .
                    $article->id  . '.pdf'
            );
        }


        $article->save();

        $message = ($article->status == 0) ? 'Tulisan anda berhasil disimpan menjadi draft' : 'Tulisah anda sudah berhasil disubmit ke Admin.';
        return redirect()->route('articles.index')
            ->with('success', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //

        Auth::user()->cannot('view', $article) ?  abort(403) : true;

        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //


        Auth::user()->cannot('update', $article) ?  abort(403) : true;
        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //

        Auth::user()->cannot('update', $article) ?  abort(403) : true;

        $request->validate([
            'title' => 'required|min:3|max:50',
            'content' => 'required',
            'file_content' => 'nullable|mimes:pdf|max:2000',
            'image_content' => 'nullable|mimes:pdf|max:2000',
        ]);

        $article->update($request->all());
        $article->status  = ($request->has('draft')) ? 0 : 1;

        if ($request->file_content != null) {
            Storage::delete($article->file_content);
            $article->file_content = $request->file('file_content')->storeAs(
                'articles',
                'file_sharing' . $article->title . '_' .
                    $article->id  . '.pdf'
            );
        }


        $article->save();

        $message = ($article->status == 0) ? 'Tulisan anda berhasil disimpan menjadi draft' :  'Tulisah anda sudah berhasil disubmit ke Admin.';
        return redirect()->route('articles.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'Data berhasil dihapus');
    }

    public function download(Article $article)
    {
        try {
            return Storage::disk('local')->download($article->file_content);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function approve(Request $request, Article $article)
    {
        Auth::user()->cannot('approve', $article) ?  abort(403) : true;

        $article->alasan = $request->alasan;
        $article->status = $request->status;
        $article->save();

        return redirect()->route('articles.index')
            ->with('success', 'Approval berhasil disimpan');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    // Constructor pentru a adăuga middleware-ul de autentificare
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Metoda pentru listarea tuturor articolelor
    public function index()
    {
        $articles = Article::all();
        return view('articles.index', compact('articles'));
    }

    // Metoda pentru afișarea formularului de creare a unui articol
    public function create()
    {
        if (!auth()->user()->hasRole('jurnalist')) {
            abort(403, 'Doar jurnaliștii pot crea articole');
        }

        return view('articles.create');
    }

    // Metoda pentru salvarea unui nou articol
    public function store(Request $request)
    {
        if (!auth()->user()->hasRole('jurnalist')) {
            abort(403, 'Doar jurnaliștii pot salva articole');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'content' => 'required',
            // Alte reguli de validare necesare
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $article = new Article();
        $article->title = $request->title;
        $article->content = $request->content;
        $article->journalist_id = auth()->user()->id;
        $article->save();

        return redirect()->route('articles.show', $article->id);
    }

    // Metoda pentru afișarea unui articol
    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('articles.show', compact('article'));
    }

    // Metoda pentru afișarea articolului pentru editare
    public function edit($id)
    {
        $article = Article::findOrFail($id);

        if (!auth()->user()->hasRole('editor') && $article->journalist_id !== auth()->user()->id) {
            abort(403, 'Doar editorii sau autorul pot edita acest articol');
        }

        return view('articles.edit', compact('article'));
    }

    // Metoda pentru actualizarea articolului
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        if (!auth()->user()->hasRole('editor') && $article->journalist_id !== auth()->user()->id) {
            abort(403, 'Doar editorii sau autorul pot actualiza acest articol');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'content' => 'required',
            // Alte reguli de validare necesare
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $article->title = $request->title;
        $article->content = $request->content;
        $article->save();

        return redirect()->route('articles.show', $article->id);
    }

    // Metoda pentru ștergerea unui articol
    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        if (!auth()->user()->hasRole('editor') && $article->journalist_id !== auth()->user()->id) {
            abort(403, 'Doar editorii sau autorul pot șterge acest articol');
        }

        $article->delete();

        return redirect()->route('articles.index');
    }
}

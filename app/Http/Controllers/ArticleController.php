<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    // Asigurați-vă că utilizatorul este autentificat pentru toate acțiunile în acest controller
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Afișează o listă cu toate articolele
    public function index()
    {
        $articles = Article::all();
        return view('articles.index', compact('articles'));
    }

    // Arată formularul pentru crearea unui articol nou
    public function create()
    {
        // Verifică dacă utilizatorul are rolul de jurnalist
        if (!Auth::user()->hasRole('jurnalist')) {
            abort(403, 'Accesul permis doar pentru jurnaliști.');
        }
        return view('articles.create');
    }

    // Stochează un articol nou în baza de date
    public function store(Request $request)
    {
        // Validează cererea
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        // Crează un nou articol și salvează-l
        $article = new Article($validatedData);
        $article->journalist_id = Auth::user()->journalist->id;
        $article->save();

        // Redirecționează către pagina de afișare a articolului
        return redirect()->route('articles.show', $article);
    }

    // Afișează un articol specific
    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    // Arată formularul pentru editarea unui articol specific
    public function edit(Article $article)
    {
        // Verifică dacă utilizatorul este autorul articolului sau are rolul de editor
        if (Auth::id() !== $article->journalist_id && !Auth::user()->hasRole('editor')) {
            abort(403, 'Numai autorul sau editorii pot edita acest articol.');
        }
        return view('articles.edit', compact('article'));
    }

    // Actualizează un articol specific în baza de date
    public function update(Request $request, Article $article)
    {
        // Validează cererea
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        // Actualizează articolul
        $article->fill($validatedData);
        $article->save();

        // Redirecționează către pagina de afișare a articolului
        return redirect()->route('articles.show', $article);
    }

    // Șterge un articol specific
    public function destroy(Article $article)
    {
        // Verifică dacă utilizatorul este autorul articolului sau are rolul de editor
        if (Auth::id() !== $article->journalist_id && !Auth::user()->hasRole('editor')) {
            abort(403, 'Numai autorul sau editorii pot șterge acest articol.');
        }
        $article->delete();

        // Redirecționează către lista de articole
        return redirect()->route('articles.index');
    }
}

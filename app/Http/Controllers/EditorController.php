<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class EditorController extends Controller
{
    // Afișează lista articolelor care așteaptă revizuire
    public function index()
    {
        $articles = Article::where('status', 'pending')->get();
        return view('editor.articles.index', compact('articles'));
    }

    // Afișează formularul de editare pentru un articol
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('editor.articles.edit', compact('article'));
    }

    // Actualizează articolul după revizuire
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        // Aici poți adăuga logica de validare și actualizare a articolului
        $article->update([
            'status' => $request->status, // Exemplu: 'aprobat'
        ]);

        return redirect()->route('editor.articles.index')
                         ->with('success', 'Articolul a fost actualizat.');
    }

    // Afișează detaliile unui articol
    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('editor.articles.show', compact('article'));
    }

    // Șterge un articol
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('editor.articles.index')
                         ->with('success', 'Articolul a fost șters.');
    }
}
